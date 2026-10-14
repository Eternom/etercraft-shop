<?php

/*
 * Importe le wiki (dossier wiki/) dans le plugin Wiki d'Azuriom. Un fichier = une catégorie, dans l'ordre des noms :
 *
 *   # Nom de la catégorie | slug | icône Bootstrap (ex : bi bi-flag)
 *
 *   === Titre de la page | slug
 *   contenu en Markdown (tableaux compris), converti en HTML
 *
 * Relançable à volonté : catégories (même slug) et pages (même catégorie, même slug) sont mises à jour, rien n'est
 * supprimé. Une page retirée d'un fichier reste dans le wiki : la supprimer dans l'admin.
 * Liens entre pages : /wiki/<catégorie>/<page>.
 *
 * Usage, sur le VPS :   runuser -u www-data -- php wiki.php /var/www/azuriom
 */

use Azuriom\Plugin\Wiki\Models\Category;
use Azuriom\Plugin\Wiki\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require __DIR__.'/bootstrap.php';

if (! plugins()->isEnabled('wiki')) {
    fwrite(STDERR, "Le plugin Wiki n'est pas activé.\n");
    exit(1);
}

/** [catégorie [name, slug, icon], pages [[title, slug, markdown], ...]] d'un fichier. */
function readCategory(string $file): array
{
    $lines = preg_split('/\R/', file_get_contents($file));
    $header = array_map('trim', explode('|', ltrim(array_shift($lines), '# ')));
    if (count($header) !== 3) {
        throw new RuntimeException(basename($file).' : la 1re ligne doit être « # Nom | slug | icône »');
    }

    $pages = [];
    foreach ($lines as $line) {
        if (str_starts_with($line, '=== ')) {
            [$title, $slug] = array_map('trim', explode('|', substr($line, 4)) + [1 => '']);
            if ($slug === '') {
                throw new RuntimeException(basename($file).' : page sans slug : '.$line);
            }
            $pages[] = [$title, $slug, ''];
        } elseif ($pages !== []) {
            $pages[array_key_last($pages)][2] .= $line."\n";
        }
    }

    return [$header, $pages];
}

$files = glob(__DIR__.'/wiki/*.md');
sort($files);

DB::transaction(function () use ($files) {
    foreach ($files as $categoryPosition => $file) {
        [[$name, $slug, $icon], $pages] = readCategory($file);

        $category = Category::updateOrCreate(['slug' => $slug], [
            'name' => $name,
            'icon' => $icon,
            'position' => $categoryPosition,
            'is_enabled' => true,
        ]);
        echo "Catégorie : {$name} (".count($pages)." pages)\n";

        foreach ($pages as $pagePosition => [$title, $pageSlug, $markdown]) {
            $page = Page::updateOrCreate(['category_id' => $category->id, 'slug' => $pageSlug], [
                'title' => $title,
                'content' => Str::markdown(trim($markdown)),
            ]);
            // position n'est pas assignable en masse dans le plugin
            $page->position = $pagePosition;
            $page->save();
        }
    }
});

echo "Wiki importé.\n";
