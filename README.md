# Site EterCraft

Contenu du site Azuriom d'EterCraft et outils pour l'installer : catalogue de la boutique (plugin Shop), wiki
(plugin Wiki), suivi des commandes en attente.

| Fichier | Rôle |
|---|---|
| `catalog.php` | Le catalogue : grades du site, recharges de points, catégories, articles et leurs commandes |
| `import.php` | Crée ou met à jour tout le catalogue dans Azuriom (relançable) |
| `pending.php` | Commandes en attente (boutique, votes) et état d'AzLink, par serveur (lecture seule) |
| `wiki.php` · `wiki/` | Le wiki : un fichier Markdown par catégorie, importé dans le plugin Wiki (relançable) |
| `bootstrap.php` | Démarre Azuriom pour ces scripts |
| `luckperms.txt` | Groupes LuckPerms des grades, à créer une fois sur le serveur |

## Principes

- **Argent du site** : 1 point = 1 centime TTC. Les joueurs rechargent (5, 10, 20 ou 50 €, bonus de 0 à 15 %), puis achètent tout en points,
  abonnements compris. Les frais de paiement (Stripe) ne s'appliquent qu'à la recharge.
- **Grades = abonnements mensuels**, renouvelés sur le solde ; groupe LuckPerms temporaire de 32 jours (une marge si le
  renouvellement arrive en retard), retiré à l'expiration, au remboursement ou au litige.
- **Avantages temporaires = commandes d'usage seulement** (/craft, /back…). Homes et hôtel des ventes : paliers
  définitifs « jusqu'à N », dans l'ordre, retirés si le paiement est annulé.
- Les commandes passent par AzLink sur le serveur `survival` (nom dans Administration → Serveurs).
- Un achat donne le grade du site « Soutien » ; un grade du site n'est jamais abaissé par un achat (puissance).

## Le wiki

`wiki/` : un fichier par catégorie, dans l'ordre des noms. Première ligne `# Nom | slug | icône`, puis chaque page
commence par `=== Titre | slug` et s'écrit en Markdown (tableaux compris). Liens entre pages : `/wiki/<catégorie>/<page>`.
Page retirée d'un fichier : la supprimer dans l'admin (l'import ne supprime rien).

```bash
runuser -u www-data -- php /opt/etercraft-shop/wiki.php /var/www/azuriom
```

## Utilisation (VPS)

```bash
cd /opt/etercraft-shop && git pull
runuser -u www-data -- php import.php /var/www/azuriom
```

Récompense ou achat pas reçu : voir ce qui attend, éventuellement pour un joueur :

```bash
runuser -u www-data -- php /opt/etercraft-shop/pending.php /var/www/azuriom [pseudo]
```

Modifier un prix ou un texte : changer `catalog.php`, pousser, puis relancer l'import. Un article retiré du catalogue
n'est pas supprimé : le désactiver dans l'admin.
