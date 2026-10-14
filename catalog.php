<?php

/*
 * Catalogue de la boutique EterCraft, lu par import.php.
 *
 * La boutique fonctionne en argent du site (points) : 1 point = 1 centime TTC. Les joueurs rechargent leur solde
 * (offres en euros), puis achètent tout en points, abonnements compris (renouvelés chaque mois sur le solde).
 *
 * Commandes : exécutées par AzLink sur le serveur nommé 'server' ci-dessous. {player} = pseudo, {quantity} = quantité.
 * Déclencheurs : purchase (achat), renewal (renouvellement), expiration, refund (remboursement), chargeback (litige).
 */

$server = 'survival';

/** Commande lancée sur le serveur, joueur connecté requis ou non, répétée ou non selon la quantité achetée. */
$run = fn (string $trigger, array $commands, bool $online = false, bool $ignoreQuantity = true) => [
    'trigger' => $trigger,
    'commands' => $commands,
    'require_online' => $online,
    'ignore_quantity' => $ignoreQuantity,
];

/** Grade en abonnement : groupe LuckPerms de 32 jours (marge si un renouvellement arrive en retard), bonus mensuels. */
$grade = function (string $group, array $monthly) use ($run) {
    $give = array_merge(["lp user {player} parent addtemp {$group} 32d replace"], $monthly);
    $remove = ["lp user {player} parent removetemp {$group}"];

    return [
        $run('purchase', $give),
        $run('renewal', $give),
        $run('expiration', $remove),
        $run('refund', $remove),
        $run('chargeback', $remove),
    ];
};

/** Accès de 30 jours à une ou plusieurs commandes ; « accumulate » ajoute 30 jours à un accès encore actif. */
$access = fn (array $permissions) => [
    $run('purchase', array_map(fn ($perm) => "lp user {player} permission settemp {$perm} true 30d accumulate", $permissions)),
];

/** Palier définitif (homes, hôtel des ventes) : retiré si le paiement est annulé. */
$tier = fn (string $permission) => [
    $run('purchase', ["lp user {player} permission set {$permission} true"]),
    $run('refund', ["lp user {player} permission unset {$permission}"]),
    $run('chargeback', ["lp user {player} permission unset {$permission}"]),
];

return [
    'server' => $server,

    // Grades du site : badge et couleur sur le site et le forum. Un achat n'abaisse jamais un grade plus puissant.
    'roles' => [
        'Soutien' => ['color' => '#FFB347', 'power' => 1],
        'Aventurier' => ['color' => '#7FB3FF', 'power' => 10],
        'Héros' => ['color' => '#B57BFF', 'power' => 20],
        'Légende' => ['color' => '#FF7A00', 'power' => 30],
    ],

    // Recharges de points (en euros TTC), proposées sur tous les moyens de paiement actifs
    'offers' => [
        ['name' => '500 points', 'price' => 5, 'money' => 500],
        ['name' => '1 050 points', 'price' => 10, 'money' => 1050],
        ['name' => '2 200 points', 'price' => 20, 'money' => 2200],
        ['name' => '5 750 points', 'price' => 50, 'money' => 5750],
    ],

    'categories' => [
        [
            'slug' => 'grades',
            'name' => 'Grades',
            'icon' => 'bi bi-gem',
            'description' => '<p>Abonnements mensuels, renouvelés sur ton solde. Résiliable à tout moment depuis ton historique d\'achats.</p>',
            'packages' => [
                [
                    'name' => 'Aventurier',
                    'short' => 'Préfixe, couleurs, /craft, /enderchest, /back et 1 clé par mois.',
                    'description' => '<ul><li>Préfixe Aventurier et couleurs dans le chat</li><li><b>/craft</b>, <b>/enderchest</b>, <b>/back</b></li><li>1 clé de monde ressource chaque mois</li></ul>',
                    'price' => 499, 'billing' => 'subscription', 'period' => '1 months', 'role' => 'Aventurier',
                    'commands' => $grade('aventurier', ['eterresource givekey {player} 1']),
                ],
                [
                    'name' => 'Héros',
                    'short' => 'Tout Aventurier, l\'atelier, /furnace, 2 clés par mois et un /rtp toutes les 20 min.',
                    'description' => '<ul><li>Tout le grade Aventurier</li><li>Atelier : <b>/anvil</b>, <b>/smithing</b>, <b>/grindstone</b>, <b>/stonecutter</b>, et <b>/furnace</b></li><li>2 clés de monde ressource chaque mois</li><li>/rtp toutes les 20 minutes au lieu de 30</li></ul>',
                    'price' => 999, 'billing' => 'subscription', 'period' => '1 months', 'role' => 'Héros',
                    'commands' => $grade('heros', ['eterresource givekey {player} 2']),
                ],
                [
                    'name' => 'Légende',
                    'short' => 'Tout Héros, le pass premium, /back après la mort, 4 clés par mois et un /rtp toutes les 10 min.',
                    'description' => '<ul><li>Tout le grade Héros</li><li>Pass de saison <b>premium</b> chaque mois</li><li><b>/back</b> après la mort</li><li>4 clés de monde ressource chaque mois</li><li>/rtp toutes les 10 minutes</li></ul>',
                    'price' => 1599, 'billing' => 'subscription', 'period' => '1 months', 'role' => 'Légende',
                    'commands' => $grade('legende', ['eterresource givekey {player} 4', 'eterreward pass premium {player}']),
                ],
            ],
        ],
        [
            'slug' => 'commandes',
            'name' => 'Commandes',
            'icon' => 'bi bi-terminal',
            'description' => '<p>Accès de 30 jours. Racheter un accès encore actif ajoute 30 jours.</p>',
            'packages' => [
                ['name' => 'Accès /craft', 'short' => 'Ouvre une table de craft partout pendant 30 jours.', 'price' => 199,
                    'commands' => $access(['eteressential.craft'])],
                ['name' => 'Accès /enderchest', 'short' => 'Ouvre ton coffre de l\'Ender partout pendant 30 jours.', 'price' => 199,
                    'commands' => $access(['eteressential.enderchest'])],
                ['name' => 'Accès /furnace', 'short' => 'Fais cuire l\'objet en main partout pendant 30 jours.', 'price' => 199,
                    'commands' => $access(['eteressential.furnace'])],
                ['name' => 'Accès /back', 'short' => 'Retourne à ta position précédente pendant 30 jours.', 'price' => 249,
                    'commands' => $access(['eteressential.back'])],
                ['name' => 'Pack Atelier', 'short' => '/anvil, /smithing, /grindstone et /stonecutter pendant 30 jours.', 'price' => 399,
                    'commands' => $access(['eteressential.anvil', 'eteressential.smithing', 'eteressential.grindstone', 'eteressential.stonecutter'])],
            ],
        ],
        [
            'slug' => 'ressources',
            'name' => 'Ressources',
            'icon' => 'bi bi-key',
            'description' => '<p>Une clé = 30 minutes de monde ressource, à utiliser quand tu veux avec <b>/ressource</b>.</p>',
            'packages' => [
                ['name' => 'Clé de monde ressource', 'short' => '30 minutes de monde ressource. Quantité au choix.', 'price' => 119, 'quantity' => true,
                    'commands' => [$run('purchase', ['eterresource givekey {player} {quantity}'])]],
                ['name' => 'Pack 5 clés', 'short' => '5 clés de monde ressource (1,00 € la clé).', 'price' => 499,
                    'commands' => [$run('purchase', ['eterresource givekey {player} 5'])]],
                ['name' => 'Pack 10 clés', 'short' => '10 clés de monde ressource (0,85 € la clé).', 'price' => 849,
                    'commands' => [$run('purchase', ['eterresource givekey {player} 10'])]],
                ['name' => 'Clé communautaire', 'short' => 'Une clé pour chaque joueur connecté, ton nom annoncé sur tout le serveur.', 'price' => 349,
                    'commands' => [$run('purchase', ['eterresource communitykey {player} 1'])]],
                ['name' => 'Pass premium du mois', 'short' => 'La ligne premium du pass de saison, jusqu\'à la fin du mois en cours.', 'price' => 599,
                    'commands' => [$run('purchase', ['eterreward pass premium {player}'])]],
            ],
        ],
        [
            'slug' => 'confort',
            'name' => 'Confort',
            'icon' => 'bi bi-house-heart',
            'description' => '<p>Achats définitifs, à débloquer dans l\'ordre.</p>',
            'packages' => [
                ['name' => 'Homes : jusqu\'à 5', 'short' => 'Jusqu\'à 5 homes (3 par défaut). Définitif.', 'price' => 349, 'limit' => 1,
                    'commands' => $tier('eterhome.limit.5')],
                ['name' => 'Homes : jusqu\'à 7', 'short' => 'Jusqu\'à 7 homes. Définitif.', 'price' => 349, 'limit' => 1,
                    'requires' => ['Homes : jusqu\'à 5'], 'commands' => $tier('eterhome.limit.7')],
                ['name' => 'Homes : jusqu\'à 10', 'short' => 'Jusqu\'à 10 homes. Définitif.', 'price' => 499, 'limit' => 1,
                    'requires' => ['Homes : jusqu\'à 7'], 'commands' => $tier('eterhome.limit.10')],
                ['name' => 'Hôtel des ventes : jusqu\'à 10', 'short' => 'Jusqu\'à 10 objets en vente en même temps (5 par défaut). Définitif.', 'price' => 349, 'limit' => 1,
                    'commands' => $tier('etermarket.auction.listings.10')],
                ['name' => 'Hôtel des ventes : jusqu\'à 15', 'short' => 'Jusqu\'à 15 objets en vente en même temps. Définitif.', 'price' => 349, 'limit' => 1,
                    'requires' => ['Hôtel des ventes : jusqu\'à 10'], 'commands' => $tier('etermarket.auction.listings.15')],
            ],
        ],
    ],
];
