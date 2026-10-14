<?php

/*
 * Importe catalog.php dans la boutique Azuriom : grades du site, recharges de points, catégories et articles.
 * Relançable à volonté : ce qui existe déjà (même slug de catégorie, même nom d'article, d'offre ou de grade) est mis
 * à jour, rien n'est supprimé. Les articles retirés du catalogue sont à désactiver à la main dans l'admin.
 *
 * Usage, sur le VPS :   runuser -u www-data -- php import.php /var/www/azuriom
 */

use Azuriom\Models\Role;
use Azuriom\Models\Server;
use Azuriom\Plugin\Shop\Models\Category;
use Azuriom\Plugin\Shop\Models\Gateway;
use Azuriom\Plugin\Shop\Models\Offer;
use Azuriom\Plugin\Shop\Models\Package;
use Illuminate\Support\Facades\DB;

require __DIR__.'/bootstrap.php';

if (! plugins()->isEnabled('shop')) {
    fwrite(STDERR, "Le plugin Shop n'est pas activé.\n");
    exit(1);
}

$catalog = require __DIR__.'/catalog.php';

$server = Server::firstWhere('name', $catalog['server']);
if ($server === null) {
    fwrite(STDERR, "Serveur « {$catalog['server']} » introuvable (Administration → Serveurs).\n");
    exit(1);
}

DB::transaction(function () use ($catalog, $server) {
    $roles = [];
    foreach ($catalog['roles'] as $name => $role) {
        $roles[$name] = Role::updateOrCreate(['name' => $name], $role + ['is_admin' => false]);
        echo "Grade du site : {$name}\n";
    }

    $gateways = Gateway::where('is_enabled', true)->pluck('id');
    foreach ($catalog['offers'] as $offer) {
        $model = Offer::updateOrCreate(['name' => $offer['name']], $offer + ['is_enabled' => true]);
        $model->gateways()->sync($gateways);
        echo "Recharge : {$offer['name']} ({$offer['price']} €, {$gateways->count()} moyen(s) de paiement)\n";
    }
    if ($gateways->isEmpty()) {
        echo "  ! Aucun moyen de paiement actif : relance l'import après avoir configuré PayPal.\n";
    }

    foreach ($catalog['categories'] as $categoryPosition => $category) {
        $categoryModel = Category::updateOrCreate(['slug' => $category['slug']], [
            'name' => $category['name'],
            'icon' => $category['icon'],
            'description' => $category['description'],
            'position' => $categoryPosition,
            'is_enabled' => true,
        ]);
        echo "Catégorie : {$category['name']}\n";

        foreach ($category['packages'] as $packagePosition => $package) {
            $requires = Package::whereIn('name', $package['requires'] ?? [])->pluck('id');
            // Grades : leur propre grade du site, Soutien à l'expiration ; le reste : Soutien
            $role = $roles[$package['role'] ?? 'Soutien'];

            Package::updateOrCreate(['category_id' => $categoryModel->id, 'name' => $package['name']], [
                'short_description' => $package['short'],
                'description' => $package['description'] ?? '<p>'.e($package['short']).'</p>',
                'position' => $packagePosition,
                'price' => $package['price'],
                'billing_type' => $package['billing'] ?? 'one-off',
                'billing_period' => $package['period'] ?? null,
                'has_quantity' => $package['quantity'] ?? false,
                'user_limit' => $package['limit'] ?? null,
                'required_packages' => $requires,
                'required_roles' => [],
                'commands' => array_map(fn (array $command) => $command + ['server' => $server->id], $package['commands']),
                'files' => [],
                'role_id' => $role->id,
                'expired_role_id' => isset($package['role']) ? $roles['Soutien']->id : null,
                'custom_price' => false,
                'is_enabled' => true,
            ]);
            echo "  Article : {$package['name']} ({$package['price']} points)\n";
        }
    }
});

echo "Import terminé.\n";
