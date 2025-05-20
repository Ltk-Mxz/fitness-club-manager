# Fitness Club

Gestionnaire web pour un club de fitness, développé en PHP avec MySQL.

## Fonctionnalités principales

- **Gestion des abonnés** : Ajout, modification, suppression, liste, photo, type d'abonnement.
- **Gestion des coachs** : Ajout, modification, suppression, liste, photo, spécialité.
- **Gestion des disciplines** : Ajout, modification, suppression, description.
- **Gestion des équipements** : Ajout, modification, suppression, état, photo.
- **Gestion des paiements** : Enregistrement, suivi mensuel/annuel, impayés.
- **Dashboard** : Statistiques, graphiques, indicateurs clés.
- **Authentification** : Accès sécurisé par login admin.
- **Gestion des utilisateurs** : Changement de mot de passe admin.

## Installation

1. **Cloner le projet**  
   Copiez tous les fichiers dans un dossier de votre serveur web local (ex: `htdocs/fitness-club`).

2. **Base de données**  
   - Importez le fichier `fitness_club_db.sql` ou `schema.sql` dans votre serveur MySQL.
   - Modifiez le fichier `db.php` si besoin pour adapter les identifiants de connexion.

3. **Droits d'écriture**  
   - Assurez-vous que les dossiers `uploads/abonnes`, `uploads/coachs`, `uploads/equipements` existent et sont accessibles en écriture.

4. **Accès**  
   - Ouvrez `http://localhost/fitness-club/login.php` dans votre navigateur.
   - Identifiant par défaut : `admin`  
     Mot de passe par défaut : `admin` (ou celui défini dans la base)

## Structure des dossiers

- `abonne_form.php`, `coach_form.php`, etc. : formulaires CRUD
- `liste_*.php` : listes et tableaux
- `models.php` : fonctions d'accès aux données
- `db.php` : connexion à la base de données
- `uploads/` : stockage des photos
- `header.php`, `footer.php` : templates communs

## Technologies

- PHP 8+
- MySQL/MariaDB
- Bootstrap 5 (CDN)
- Chart.js (pour les graphiques)
- Google Fonts (Poppins, Montserrat)

## Sécurité

- Authentification requise pour toutes les pages (sauf login)
- Les mots de passe sont hashés (bcrypt)
- Protection contre l'accès direct non authentifié

## Personnalisation

- Modifiez les styles dans `header.php` ou directement dans les fichiers de formulaire.
- Ajoutez des rôles ou fonctionnalités selon vos besoins.

## Auteur

- **Ltk-Mxz** : [GitHub](https://github.com/Ltk-Mxz)
