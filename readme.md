# Tom Troc :

Ce projet est le 6ème de la formation Openclassrooms pour les développeur d'application Symfony.
Le but du projet est de créer entièrement un site dont la maquette est fournie (hors responsive).
Le site doit être développer en PHP, avec un design pattern MVC et en POO.
La base de données utilisée doit être relationnelle.
Le site propose la connexion / inscription pour un utilisateur.
La création / édition des livres personnels de l'utilisateur qu'il peut saisir dans son compte.
L'édition des informations de l'utilisateur.
Un système de messagerie basique entre deux utilisateurs.

# Installation du projet :

Vous pouvez cloner ce projet directement.
Il faut ensuite créer une base de donnée nommée "tomtroc".
Un fichier SQL est présent avec quelques données de test,il faut l'importer.
L'adresse mail des utilisateurs est présente en BDD en clair le mot de passe est identique pour les deux : Bonjour01
Dans le dossier config, un fichier _config.php est présent.
Il faut enlever l'underscore présent sur le nom du fichier et indiquer les informations concernant la base de données.

## Bug éventuels :

A priori, l'extension intl n'est pas obligatoire pour l'affichage des différentes dates, toutefois si un problème
survient veillez à l'activer dans votre php.ini.
De plus les droits d'écriture sur le dossier uploads sont nécessaires pour l'envoi de fichiers.
Le script gère la création du dossier s'il n'existe pas toutefois, vous pouvez le faire si besoin en créant un dossier
uploads à la racine du projet avec dedans un dossier avatar et un books.

### Fonctionnalité JS :

Le site propose un peu de dynamisme (une modale) pour l'envoi d'un message depuis une page autre que la boîte mail, mais
JS est désactivable sans perte de fonctionnalités.