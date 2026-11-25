# Vagabondage

Site web de partage de publications inspiré d'Instagram, sur le thème du manga *Vagabond*. Projet réalisé en PHP, HTML et CSS.

## Fonctionnalités

- Inscription, connexion et déconnexion
- Page de profil
- Publication de contenus (upload)
- Likes
- Recherche
- Partage

## Technologies

- PHP
- MySQL / MariaDB
- HTML / CSS
- Laragon (serveur local)

## Installation

1. Cloner le dépôt dans le dossier `www` de Laragon :

   git clone https://github.com/zer0xtech/Vagabondage.git

2. Créer une base de données `[nom_de_la_base]` puis importer le fichier SQL du dossier `SQL/` (`[nom_du_fichier].sql`).

3. Vérifier les paramètres de connexion dans `config.php`.

4. Démarrer Laragon, puis ouvrir `http://localhost/Vagabondage` dans le navigateur.

## Structure du projet

- `index.php` : page d'accueil
- `login.php`, `register.php`, `logout.php` : authentification
- `profile.php` : profil utilisateur
- `upload.php` : publication de contenu
- `search.php` : recherche
- `like_content.php`, `share.php` : likes et partage
- `config.php` : connexion à la base de données
- `SQL/` : script de création de la base
- `images/`, `fonts/` : ressources

## Pistes d'amélioration

- Nettoyer et optimiser le code
- Regrouper les feuilles de style dans un seul fichier CSS
- Ajouter une pagination quand il y a beaucoup de publications
