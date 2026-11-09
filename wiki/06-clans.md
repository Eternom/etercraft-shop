# Clans | clans | bi bi-flag

=== Fonder ou rejoindre | fonder

## Un clan, c'est une guilde

Des membres, chacun avec ses permissions, une banque, un territoire et des parcelles à louer. Le clan existe sur **tout le réseau**. Tout se gère dans un seul menu : `/clan`.

## Fonder un clan

Depuis `/clan` : choisis un **nom** et un **tag** (2 à 5 caractères). Le prix, **1 000 Heloks**, est affiché avant de payer.

Un joueur seul peut fonder **son propre clan** : c'est le moyen de protéger sa maison et son argent.

## Rejoindre un clan

Un membre qui en a la permission t'invite : accepte l'invitation depuis `/clan`. Une invitation expire au bout de **5 minutes**.

## Quitter, céder, dissoudre

- **Quitter** : ton compte de clan t'est rendu ; tes parcelles louées dans ce clan sont perdues.
- **Céder** : le chef peut donner la tête du clan à un membre.
- **Dissoudre** : chaque membre récupère son compte ; la **réserve** commune est perdue.

=== Membres et permissions | permissions

## Des permissions, et des rôles pour aller vite

Le **chef** a tout. Chaque autre membre a **ses propres permissions**, données une par une dans le menu des membres par qui en a le droit, ou d'un coup avec un **rôle** : **Recrue** (portes, cultures, animaux), **Membre** (en plus : construire, coffres, redstone, homes), **Officier** (en plus : inviter, exclure, terrain, parcelles, accès).

| Permission | Elle permet de |
|---|---|
| Construire | poser et casser des blocs sur le territoire |
| Coffres | ouvrir les coffres et autres contenants |
| Portes | utiliser portes, trappes et portillons |
| Redstone | utiliser leviers, boutons, plaques |
| Cultures | récolter et planter |
| Animaux | interagir avec les animaux |
| Inviter | inviter de nouveaux membres |
| Exclure | exclure un membre |
| Terrain | prendre ou rendre des chunks |
| Parcelles | créer, louer et gérer les parcelles |
| Accès | ouvrir ou fermer le terrain, vendre des passes, la liste noire |
| Réserve | prendre de l'argent dans la réserve |
| Intérêt | régler l'intérêt de la banque |
| Permissions | changer les permissions des autres |

Un nouveau membre peut d'office utiliser les **portes**, les **cultures** et les **animaux**.

=== Le territoire | territoire

## Le cœur, gratuit

Les terres se prennent **par chunk** (16 × 16 blocs, sur toute la hauteur), **sur la survie**, depuis `/clan` (**Terrain**). Le premier chunk que ton clan prend devient son **chunk primaire** : le **carré de 3 × 3 chunks** autour est pris avec lui. Ce **cœur** est **gratuit et sans entretien**.

Le cœur ne se rend pas en morceaux : seul le chef peut rendre **tout** le terrain d'un coup.

## S'agrandir

| | Où | Prix |
|---|---|---|
| **Extension** | contre ta base (reliée au cœur) | 250 Heloks, puis 7 % de plus à chaque nouvelle (jamais plus de 3 750) |
| **Avant-poste** | n'importe où, loin de ta base (une mine, une ferme, un portail) | une fois et demie le prix d'une extension |

Tout chunk hors du cœur se **paie tout de suite**, par la **réserve** du clan. Un avant-poste fait au plus **4 chunks**, et le nombre d'avant-postes dépend du **niveau** du clan :

| Niveau | Il faut | Avant-postes |
|---|---|---|
| 1 | — | 1 |
| 2 | 3 membres et 20 chunks | 2 |
| 3 | 6 membres et 40 chunks | 3 |

Être dans le **top 3 du classement du mois** donne un niveau de plus.

Pas de chunk collé au terrain d'un autre clan (**un chunk d'écart**), ni dans les zones réservées (le spawn).

## La carte

Le bouton **Carte** de `/clan` montre les chunks autour de toi : **or** pour le cœur, **vert** pour ta base, **bleu** pour tes avant-postes, **rouge** pour un autre clan. Clique sur les chunks libres pour en **choisir plusieurs**, avec le prix de chacun et le total, puis prends-les d'un coup.

## Rendre un chunk

Un chunk payant rendu rembourse **25 %** de son prix dans la réserve. On ne peut pas rendre un chunk qui couperait ta base ou un avant-poste en deux.

## L'entretien

Chaque semaine, le clan paie un entretien pour ses chunks **payants**, par la **réserve** : 20 Heloks pour le premier, puis 4 % de plus pour chaque suivant ; un chunk d'avant-poste coûte une fois et demie plus. Le top 3 du mois paie **30 %, 20 % ou 10 % de moins**.

| Territoire | Achat total | Entretien par semaine |
|---|---|---|
| 9 chunks (le cœur) | gratuit | rien |
| 15 chunks | 1 788 | 132 |
| 20 chunks | 3 946 | 268 |
| 30 chunks | 11 217 | 638 |
| 50 chunks | environ 53 600 | environ 2 000 |

Si la réserve ne suffit pas, le clan est **en dette** : il a **14 jours** pour la remplir, avec des rappels. Ensuite, il perd des chunks : ses **avant-postes** d'abord, puis les chunks **les plus loin du cœur**, sans jamais couper la base. **Le cœur ne se perd jamais.**

Un clan dont personne ne vient pendant **30 jours** perd ses chunks payants ; au bout de **60 jours**, tout son terrain.

## Le home et le cœur

- `/clan sethome` pose le **home du clan** sur votre terrain ; `/clan home` y emmène, avec les règles de téléportation habituelles.
- Le chef peut **déplacer le cœur** sur un autre chunk de la base, une fois par mois (5 000 Heloks).

## Qui entre sur ton terrain

Le menu **Accès** règle le terrain :

| Mode | Qui entre |
|---|---|
| **Ouvert** | tout le monde ; agir demande une permission |
| **Fermé** | les membres et les invités seulement |
| **À pass** | ceux qui ont acheté un **pass** (ou sont invités) |

- **Le pass** : vous choisissez son prix, sa durée (1 à 30 jours) et ce qu'il permet (portes, redstone, cultures, animaux, coffres ; jamais construire). L'argent va dans la réserve. Posez un panneau avec **[Pass]** sur la première ligne : il devient un guichet, clic droit pour acheter. Idéal pour louer l'accès à une ferme.
- **Les invités** : un accès gratuit pour quelques heures (1 h à 7 jours).
- **La liste noire** : ces joueurs n'entrent nulle part sur votre terrain.

Sur un terrain fermé, on est repoussé au bord, et aucune téléportation n'y mène (perle de l'Ender, fruit de chorus, demande de téléportation).

## La protection

Sur ton territoire, seuls les membres, selon leurs permissions (et les détenteurs d'un pass, pour ce qu'il permet), peuvent construire, ouvrir les coffres, utiliser portes, redstone, cultures et animaux. Les supports d'armure, les laisses, les bateaux et chevaux, la canne à pêche et les potions lancées sont protégés aussi. Et le monde n'y entre pas :

- pas d'explosions, de feu qui se propage ni de pistons venus de l'extérieur ;
- pas de liquides qui coulent depuis dehors ;
- pas de monstres qui abîment les blocs ou piétinent les cultures ;
- pas de flèches sur les boutons ni sur les blocs fragiles ;
- **pas de combat entre joueurs**.

En entrant sur le terrain d'un autre clan, son nom s'affiche au milieu de l'écran.

## Savoir ce qui est permis

Le menu `/clan` a une page **Règles du territoire** : ce que **toi** tu peux faire sur le terrain du clan, ce que tu peux faire **là où tu te tiens**, et les protections toujours actives.

Une **parcelle louée** a ses propres règles : seuls son locataire et ceux qu'il autorise y agissent, jamais les permissions du clan. Voir [Les parcelles](/wiki/clans/parcelles).

## Le journal

Le bouton **Journal** montre les dernières actions du clan (chunks pris ou rendus, invitations, permissions, accès), et la banque l'**historique de la réserve**.

=== La banque | banque

## Deux sortes d'argent

| | À qui | À quoi il sert |
|---|---|---|
| **Ton compte** | à toi seul | ton épargne, **protégée de la perte d'argent à la mort** |
| **La réserve** | au clan | payer les terres et l'entretien |

Tout membre peut **donner** à la réserve, après **5 heures de jeu** ; seuls ceux qui ont la permission **Réserve** peuvent y **prendre**.

## L'intérêt

Chaque semaine, un **intérêt** est pris sur le compte de chaque membre et versé à la réserve : **2 %** au départ, réglable de **0 à 10 %** par qui a la permission **Intérêt**. C'est ainsi que le clan finance son territoire.

## Pourquoi c'est utile seul

En mourant, tu perds 5 % de l'argent que tu as sur toi. Celui de ton compte de clan est à l'abri : fonder un clan d'une personne suffit.

=== Les parcelles à louer | parcelles

## Louer une partie de vos terres

Une **parcelle** est un rectangle de votre territoire, sur toute la hauteur, que d'autres joueurs peuvent louer pour y construire.

## Créer une parcelle

Avec la permission **Parcelles** : dans `/clan`, choisis **Nouvelle parcelle**, puis clique sur deux blocs dans le monde pour en marquer les coins. Un aperçu en particules s'affiche ; valide dans le chat.

- **64 × 64 blocs** au plus ;
- dans votre territoire, sans chevaucher une autre parcelle.

## La location

- Le clan fixe un **loyer par semaine**.
- Un membre la loue (ou **n'importe quel joueur**, si le clan l'ouvre à tous : un panneau **[Louer]** dans la parcelle sert de guichet) : la **première semaine est payée tout de suite**, puis le loyer est prélevé chaque semaine sur son argent et versé à la réserve. Un rappel arrive 2 jours avant ; un loyer impayé laisse **une semaine de grâce**.
- Une fois louée, **seul le locataire** (et ceux qu'il choisit) peut y agir : les permissions du clan ne s'y appliquent plus.
- Une parcelle louée ne peut pas être supprimée ; un membre qui quitte le clan perd ses locations.
- Si le clan perd le chunk d'une parcelle louée, le locataire est remboursé du reste de sa semaine.

## L'accès à une parcelle

Une parcelle peut aussi avoir ses propres règles : **réservée** (seuls ceux que le clan choisit y agissent, comme une salle des coffres d'officiers), **fermée**, ou **à pass** (avec son propre prix).

=== Le tag du clan | tag

## Ton tag partout

Le **tag** de ton clan s'affiche à côté de ton pseudo, partout sur le réseau : liste des joueurs, chat, au-dessus de ta tête et dans ton tableau de bord. Il remplace ton grade.

## Préférer ton grade

Tu préfères afficher ton grade plutôt que le tag du clan ? Clique sur ta tête dans le menu `/clan` pour choisir.

## Le classement du mois

Chaque mois, les clans sont classés sur **4 critères**, comme le classement général des joueurs : dans chacun, une note sur 100 selon la place du clan, puis la moyenne.

| Critère | Ce qu'il compte ce mois-ci |
|---|---|
| **Activité** | le temps de jeu actif des membres (sans AFK) |
| **Travail** | les quêtes de métier et les défis des membres |
| **Trésor** | l'argent donné à la réserve, **moins** ce qui en est repris |
| **Expansion** | les chunks pris, **moins** ceux rendus ou perdus |

Donner puis reprendre, ou prendre puis rendre des chunks, ne rapporte donc rien. À la fin du mois, le **top 3** gagne de l'argent versé dans sa réserve : **3 000**, **2 000** et **1 000 Heloks**.

Tout est visible dans `/clan` → **Classement du mois**, et dans les [classements](/wiki/progression/classements) (« Clans du mois »).
