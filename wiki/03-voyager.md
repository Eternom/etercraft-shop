# Se déplacer | voyager | bi bi-signpost-2

=== Les homes | homes

## Poser et rejoindre

| Commande | Ce qu'elle fait |
|---|---|
| `/sethome [nom]` | Pose un home là où tu es (sans nom : « home ») |
| `/home [nom]` | Te téléporte à un home, même sur un autre serveur |
| `/homes` | Le menu de tes homes |
| `/delhome <nom>` | Supprime un home |

Depuis le menu : **Voyager → Mes homes**.

## Combien

Tu as **3 homes**. Tu peux en avoir plus avec les paliers de la boutique : **jusqu'à 5**, **jusqu'à 7**, puis **jusqu'à 10** (achats définitifs, dans l'ordre). Voir [Les avantages](/wiki/boutique/avantages).

## Les règles

Un home suit les [règles de téléportation](/wiki/voyager/regles-teleportation) : attente, délai, combat.

=== Rejoindre un joueur | teleportation

## Demander

| Commande | Ce qu'elle fait |
|---|---|
| `/tpa <joueur>` | Demander à **aller** vers un joueur (`/tpa` seul : choisir dans la liste) |
| `/tpahere <joueur>` | Demander à un joueur de **venir** |
| `/tpaccept` · `/tpdeny` (`/tpy` · `/tpn`) | Accepter ou refuser ; avec plusieurs demandes, un menu pour choisir |
| `/tpa list` | Les demandes reçues, avec la tête de chaque joueur |
| `/tpacancel` | Annuler ta demande |
| `/tpaclan` | Faire venir tous les membres connectés de ton clan |

Depuis le menu (**Voyager**), choisis le joueur dans la liste : il reçoit la demande et l'accepte d'un clic dans le chat ([Accepter] [Refuser] [Ignorer]). Tant qu'il n'a pas répondu, un rappel reste au-dessus de sa barre d'objets.

## Une fois acceptée

Tu es prévenu, et un compte à rebours s'affiche au milieu de l'écran. **Tu peux bouger** : seul un coup reçu ou donné annule le départ. Si le départ échoue (combat, délai), la demande n'est pas perdue : un bouton **[Réessayer]** permet de l'accepter de nouveau.

Tu arrives toujours sur un bloc sûr à côté du joueur (jamais dans la lave ni dans un mur), et personne ne peut te blesser pendant **3 secondes** (sauf si tu frappes).

Entre membres d'un même clan, pas d'attente.

## Qui peut t'envoyer une demande

| Commande | Ce qu'elle fait |
|---|---|
| `/tptoggle` | Tout le monde → amis et clan seulement → personne |
| `/tptoggle here` | Refuser (ou réaccepter) qu'on te fasse venir |
| `/tpaignore <joueur>` | Ne plus recevoir les demandes d'un joueur |
| `/tpaauto <joueur>` | Accepter ses demandes toutes seules (un ami) |
| `/tpaauto clan` | Accepter toutes seules celles de ton clan |

## Bon à savoir

- Une demande expire au bout de **60 secondes** ; tu es prévenu si elle expire sans réponse, ou si le joueur quitte le réseau.
- Tu n'as qu'une demande en cours à la fois, et pas deux demandes au même joueur en moins de **10 secondes**.
- Pas de demande à un joueur en plein combat.
- Ça marche même si vous n'êtes pas sur le même serveur.

=== Téléportation aléatoire | teleportation-aleatoire

## Partir à l'aventure

Depuis le menu (**Voyager → Téléportation aléatoire**) ou avec `/rtp` : choisis le monde, et tu arrives à un endroit sûr, au hasard, loin du spawn.

| Monde | Distance du centre |
|---|---|
| Surface | de 500 à 5 000 blocs |
| Nether | de 200 à 1 000 blocs |
| End | de 1 000 à 3 000 blocs |

## Le délai

Une téléportation aléatoire toutes les **30 minutes**, sur tout le réseau. Les grades la raccourcissent : **20 minutes** pour Héros, **10 minutes** pour Légende. Voir [Les grades](/wiki/boutique/grades).

Seulement sur la survie : pas sur les lobbys.

=== Revenir en arrière | retour

## La commande /back

`/back` te ramène à l'endroit que tu as quitté lors de ta dernière téléportation (home, joueur, aléatoire...), même sur un autre serveur. Avec le grade **Légende**, il ramène aussi à l'endroit de ta **mort**.

## L'obtenir

- Avec un grade : **Aventurier** et plus (voir [Les grades](/wiki/boutique/grades)) ;
- en accès de 30 jours dans la boutique (voir [Les avantages](/wiki/boutique/avantages)) ;
- pour un temps, avec certaines récompenses du [pass de saison](/wiki/progression/pass-de-saison).

=== Les règles de téléportation | regles-teleportation

Homes, demandes entre joueurs, téléportation aléatoire, `/back` : les mêmes règles partout, pour qu'on ne fuie pas un combat.

| Règle | Durée |
|---|---|
| Attente avant de partir (un coup reçu ou donné l'annule ; bouger aussi, sauf pour une demande entre joueurs) | **3 secondes** (moins avec un [grade](/wiki/boutique/grades)) |
| Délai entre deux téléportations, sur tout le réseau | **30 secondes** |
| Pas de téléportation après avoir donné ou reçu un coup, d'un joueur **ou d'un monstre** | **10 secondes** |

Le compte à rebours s'affiche au milieu de l'écran. Une chute, la faim ou le feu n'annulent plus le départ : seulement un coup.
