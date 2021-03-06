# nazca
![# NAZCA](https://raw.githubusercontent.com/CHEN-AND-CO/nazca/master/chenco_NAZCA_logo.png)

NAZCA est un outil permettant le calcul de profils NACA. Il fournit la possibilité d'obtenir des graphes d'allure du profil et de rigidité / solidité.

# Installation
## Téléchargement
Deux solutions s'offrent à vous : 
* Vous pouvez télécharger le projet au format zip. Il vous suffira alors de disposer d'outils standards de décompression pour l'extraire.
* Vous pouvez cloner le Git officiel du projet, en utilisant la commande suivante (en supposant que l'utilitaire Git est installé sur votre machine) : 
``` 
git clone https://github.com/CHEN-AND-CO/nazca.git
```
## Dépendances
Vous devez posséder sur votre machine :
* PHP version 7 ou supérieur
* Un serveur Web (Apache, nginx...)
* MySQL

Il est conseillé d'utiliser Linux pour faire fonctionner le projet, bien qu'un environnement WAMP suffirait, mais cela n'a pas été testé.

## Mise en place de la base de données
Une base de données MySQL doit être pré-installée sur votre système. Procédez à son installation si nécessaire.
Afin de créer la base de données de NAZCA, il vous faudra exécuter le fichier bdd.sql fourni à la racine du projet, en utilisant la commande `source bdd.sql` une fois connecté à votre base de données.

Le fichier php/constantes.php fournit les différentes informations d'accés à la base de données. Il peut être judicieux d'en modifier les droits d'accés ou de modifier les identifiants de connection en fonction de vos besoins.
## Installation des fichiers du projet
Clonez le Git du projet ou décompressez l'archive fournie (selon la façon dont vous avez récupéré le projet) dans un nouveau répertoire *vide*.

La configuration d'un hôte virtuel peut être nécessaire/souhaitable en fonction du serveur web que vous utilisez. 

Il n'est pas nécessaire de procéder à d'autres étapes de configuration.
# Utilisation
L'interface se veut ergonomique et explicite d'utilisation.

Le bouton "Nouveau profil" sur la page d'accueil permet la création d'un profil. 
Sur la page de création d'un profil, veuillez remplir tous les champs puis valider. Aprés calcul du profil, celui-ci sera affiché.

La page de consultation d'un profil permet de visualiser les caractéristiques du profil et son apparence. 
Les graphes de rigidité/solidité sont accessibles en cliquant sur "Voir tous les graphes". 

Notez qu'il est possible de télécharger un graphe en le cliquant. De même le téléchargement des données au format CSV est possible à l'aide du bouton éponyme.
