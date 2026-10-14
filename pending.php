<?php

/*
 * Commandes en attente (boutique, votes) : celles qu'AzLink n'a pas encore récupérées, serveur par serveur, avec l'état
 * de la liaison AzLink. Lecture seule. Une commande reste en attente tant que :
 *   - AzLink du serveur ne contacte pas le site (plugin absent, pas relié, serveur éteint) ;
 *   - ou elle demande le joueur en ligne et il n'est pas sur CE serveur.
 *
 * Usage, sur le VPS :   runuser -u www-data -- php pending.php /var/www/azuriom [pseudo]
 */

use Azuriom\Models\Server;

require __DIR__.'/bootstrap.php';

$player = $argv[2] ?? null;
$total = 0;

foreach (Server::all() as $server) {
    // isOnline : AzLink a donné des nouvelles il y a moins de 5 minutes (cache rempli à chaque échange)
    $link = $server->isOnline()
        ? 'AzLink relié, '.$server->getOnlinePlayers().' joueur(s) en ligne'
        : 'AUCUN contact d\'AzLink depuis 5 min : plugin absent, non relié (azlink setup) ou serveur éteint';
    echo "== {$server->name} ({$link})\n";

    $commands = $server->commands()->with('user')
        ->when($player !== null, fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', $player)))
        ->oldest()
        ->get();

    if ($commands->isEmpty()) {
        echo "   aucune commande en attente\n";
    }

    foreach ($commands as $command) {
        $waiting = $command->need_online ? ' [attend le joueur sur ce serveur]' : '';
        echo '   '.$command->created_at->format('d/m H:i').'  '.($command->user?->name ?? '-').'  '.$command->command.$waiting."\n";
    }
    $total += $commands->count();
}

echo "{$total} commande(s) en attente.\n";
