<?php

/*
 * Prépare le forum (plugin Forum d'Azuriom) : catégories, forums, étiquettes et sujets de départ.
 *
 * Le forum ne répète pas le wiki : le wiki dit comment marche le serveur, le forum garde ce que la communauté produit
 * (nouveautés, idées, bugs, clans, créations, échanges) et le recrutement du staff.
 *
 * Sujets de départ : forum/<slug du forum>.md, un sujet par bloc « === Titre | options », contenu en Markdown.
 * Options : épinglé, verrouillé (séparées par des virgules).
 *
 * Relançable : catégories (même nom), forums (même slug), étiquettes (même nom) et sujets (même forum, même titre)
 * sont mis à jour, rien n'est supprimé. Les sujets sont publiés au nom du compte donné en 2e argument.
 *
 * Usage, sur le VPS :   runuser -u www-data -- php forum.php /var/www/azuriom NadTum
 */

use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Tag;
use Illuminate\Support\Facades\DB;

require __DIR__.'/bootstrap.php';

if (! plugins()->isEnabled('forum')) {
    fwrite(STDERR, "Le plugin Forum n'est pas activé.\n");
    exit(1);
}

$author = User::where('name', $argv[2] ?? '')->first();
if ($author === null) {
    fwrite(STDERR, "Compte introuvable : donne le pseudo de l'auteur des sujets en 2e argument.\n");
    exit(1);
}

// Étiquettes : seul le staff (permission forum.tags) peut les changer ; celles par défaut se posent toutes seules
$tags = [
    'À l\'étude' => '#f59e0b',
    'Acceptée' => '#22c55e',
    'Refusée' => '#ef4444',
    'Ajoutée' => '#3b82f6',
    'À traiter' => '#f59e0b',
    'Confirmé' => '#f97316',
    'Corrigé' => '#22c55e',
    'Pas un bug' => '#6b7280',
    'En attente' => '#f59e0b',
    'Entretien' => '#3b82f6',
    'Développeur' => '#8b5cf6',
    'Builder' => '#14b8a6',
    'Community manager' => '#ec4899',
    'Modérateur' => '#ff7a00',
];

/*
 * Catégorie => [description, forums]. Forum : slug => [nom, icône, description, options, étiquette par défaut].
 * verrouillé : seul le staff ouvre des sujets (les joueurs répondent) ; privé : chacun ne voit que ses sujets
 * (et les sujets épinglés), le staff voit tout.
 */
$structure = [
    'EterCraft' => ['La vie du serveur : ce qui change, vos idées, les bugs.', [
        'nouveautes' => ['Nouveautés', 'bi bi-megaphone', 'Mises à jour, événements et annonces du staff.', ['verrouillé'], null],
        'suggestions' => ['Suggestions', 'bi bi-lightbulb', 'Une idée pour le serveur ? Propose-la, la communauté vote.', [], 'À l\'étude'],
        'bugs' => ['Bugs', 'bi bi-bug', 'Quelque chose ne marche pas comme prévu ? Dis-le ici.', [], 'À traiter'],
    ]],
    'Communauté' => ['Entre joueurs.', [
        'clans' => ['Clans', 'bi bi-flag', 'Présente ton clan et recrute, ou trouve celui qui te correspond.', [], null],
        'creations' => ['Créations', 'bi bi-image', 'Constructions, fermes, décors : montre ce que tu as bâti.', [], null],
        'commerce' => ['Commerce', 'bi bi-arrow-left-right', 'Gros lots, commandes et services entre joueurs.', [], null],
    ]],
    'Recrutement' => ['Rejoindre l\'équipe d\'EterCraft.', [
        'candidatures' => ['Candidatures', 'bi bi-person-badge', 'Développeur, builder, community manager, modérateur : postule ici. Ta candidature n\'est visible que par toi et le staff.', ['privé'], 'En attente'],
    ]],
];

/** [[titre, options, markdown], ...] d'un fichier de sujets. */
function readTopics(string $file): array
{
    $topics = [];
    foreach (preg_split('/\R/', file_get_contents($file)) as $line) {
        if (str_starts_with($line, '=== ')) {
            [$title, $options] = array_map('trim', explode('|', substr($line, 4)) + [1 => '']);
            $topics[] = [$title, array_filter(array_map('trim', explode(',', $options))), ''];
        } elseif ($topics !== []) {
            $topics[array_key_last($topics)][2] .= $line."\n";
        }
    }

    return $topics;
}

DB::transaction(function () use ($tags, $structure, $author) {
    $tagIds = [];
    foreach (array_keys($tags) as $position => $name) {
        $tag = Tag::updateOrCreate(['name' => $name], ['color' => $tags[$name], 'position' => $position]);
        $tagIds[$name] = $tag->id;
    }

    $categoryPosition = 0;
    foreach ($structure as $categoryName => [$categoryDescription, $forums]) {
        $category = Category::updateOrCreate(['name' => $categoryName], [
            'description' => $categoryDescription,
            'position' => $categoryPosition++,
        ]);

        $forumPosition = 0;
        foreach ($forums as $slug => [$name, $icon, $description, $options, $defaultTag]) {
            $forum = Forum::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'icon' => $icon,
                'description' => $description,
                'category_id' => $category->id,
                'position' => $forumPosition++,
                'is_locked' => in_array('verrouillé', $options, true),
                'is_private' => in_array('privé', $options, true),
                'default_tags' => $defaultTag === null ? null : [$tagIds[$defaultTag]],
            ]);

            $file = __DIR__."/forum/{$slug}.md";
            $topics = is_file($file) ? readTopics($file) : [];
            echo "Forum : {$categoryName} › {$name} (".count($topics)." sujets)\n";

            foreach ($topics as [$title, $topicOptions, $markdown]) {
                $discussion = Discussion::firstOrNew(['forum_id' => $forum->id, 'title' => $title]);
                // auteur, épinglé et verrouillé ne sont pas assignables en masse dans le plugin
                $discussion->forceFill([
                    'forum_id' => $forum->id,
                    'author_id' => $discussion->author_id ?? $author->id,
                    'is_pinned' => in_array('épinglé', $topicOptions, true),
                    'is_locked' => in_array('verrouillé', $topicOptions, true),
                ])->save();

                $post = $discussion->posts()->oldest()->first() ?? $discussion->posts()->make()->forceFill(['author_id' => $author->id]);
                $post->fill(['content' => trim($markdown), 'content_format' => 'markdown'])->save();
            }
        }
    }
});

echo "Forum prêt.\n";
