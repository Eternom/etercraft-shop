<?php

/*
 * Démarre Azuriom comme une commande artisan (base, réglages, plugins chargés), pour les scripts de ce dossier.
 * Le dossier d'Azuriom est le premier argument, /var/www/azuriom par défaut.
 */

use Illuminate\Contracts\Console\Kernel;

$azuriom = rtrim($argv[1] ?? '/var/www/azuriom', '/');

if (! is_file($azuriom.'/artisan')) {
    fwrite(STDERR, "Azuriom introuvable dans {$azuriom}\n");
    exit(1);
}

require $azuriom.'/vendor/autoload.php';
$app = require $azuriom.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
