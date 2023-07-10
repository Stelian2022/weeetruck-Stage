# Projet weeetruck
# Prérequis

- PHP 8.1 minimum
- MySQL 5.7
- Composer (https://getcomposer.org/download/)
- GIT (https://gitforwindows.org/)

# Récupération du projet

Le dépôt est à récupérer via la ligne de commande suivante : `git clone -b weeetruck https://github.com/BouazziH/weeetruck.git`

## Création crud
### 1- installation doctrine: bibliothèque fournir des outils puissants pour rendre les interactions avec les bases de données faciles et flexibles.

    a- composer require symfony/orm-pack 

    b- composer require symfony/maker-bundle --dev 

### 2-configuration base de donne:

    Les paramètres de la connexion à la base de donne sont stockées dans la variable DATABASE_URL qui existe dans la fichier .env.
    Exemple:
    DATABASE_URL=‘mysql://db_user:db_password@127.0.0.1:3306/db_name’
    db_user: root
    db_password: par défaut vide 
    db_name: nom de votre base par exemple 'crud_symfony'

DATABASE_URL='mysql://root:@127.0.0.1:3306/crud_symfony'

### 3- création base de données :

php bin/console doctrine:database:create

### 4- Création d’entité:

 php bin/console make:entity
 >nom de classe/entite

### 5- Migrations: Création des tables / schémas de la base de données

    a- php bin/console make:migration 
    b- php bin/console doctrine:migrations:migrate 

### 6- Création crud

php bin/console make:crud 
  >nom du classe

### 7- Exécution du projet

    symfony server:start


# Pour vous aider

Quelques liens utiles pour comprendre les différents composants de Symfony :
- La gestion des entités dans Symfony : https://symfony.com/doc/current/doctrine.html
- Les controlleurs Symfony : https://symfony.com/doc/4.4/controller.html
- Les formulaire Symfony : https://symfony.com/doc/4.4/forms.html
- Documentation Twig : https://twig.symfony.com/doc/3.x/
   