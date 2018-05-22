tales_of_galaxy
===============

## Pourquoi Symfony

Après 5 ans sur phpBB, j'ai décidé de passer sur Symfony afin d'avoir vraiment la main sur mon projet. C'était à la fois l'occasion de tester un framework éprouvé et validé par la communauté PHP, et de mettre à jour mon forum viellissant.

## Bundles et technologies employées :

### MySQL

J'ai choisi SQL, et plus particulièrement, MySQL pour deux raisons :  

* Je ne ressentais pas le besoin de faire du NoSQL pour ce projet. Une base de données relationnelles me semble tout à fait convenir à un forum, particulièrement un forum à petit trafic
* C'est aussi la techno de BDD que je maîtrise le plus 

### Assetic 

Quand j'ai commencé le projet, je n'avais encore jamais entendu parler de Webpack. Assetic était le choix pertinent à l'époque, mais dans la mesure où j'ai l'intention de refaire la partie front avec React, je finirais par m'en passer.

### jQuery

Là aussi, j'ai choisi jQuery parce que c'était le meilleur choix pour moi à l'époque. Aujourd'hui, je n'utilise plus du tout cette librairie dans mon travail quotidien, et j'ai prévu de m'en passer pour ce projet lorsque je reprendrais en main le front.

## Fonctionnalités implémentées

Le projet est séparé en deux grosses parties (qui ont chacun leur bundle) : la partie "forum" et la partie "role-play". Pour l'instant, c'est la première qui est le plus avancée.  

On peut :  

* S'inscrire au forum et s'y connecter
* Consulter les utilisateurs connectés 
* Créer des forums et des sous-forums à l'infini, via une interface admin sécurisée
* Ouvrir des sujets dans ces forums
* Poster des messages dans ces sujets
* Créer un personnage

## Fonctionnalités à implémenter

Voici les fonctionnalités qui restent à implémenter :  

* Gérer les permissions des membres et des forums
* Modifier son profil membre
* Modifier son personnage
* Prévisualiser son message avant de poster
* Pouvoir enregistrer un brouillon de son message
* Système de niveaux, compétences et talents pour les personnages
* Système de jets de dés
* Système de création de campagnes
* Système de messagerie privée
* Système de chat (peut-être remplacé par Discord)
* Etc...

## Améliorations et prochaines étapes

### Refonte du front

Comme évoqué précédemment, je compte refaire toute la partie front avec un framework JS avec webpack. Mon choix se porte pour l'instant sur ReactJS mais je réfléchis aux alternatives (plutôt VueJS qu'Angular).

### Tests end-to-end et tests unitaires

Il n'y a actuellement aucun tests sur ce projet. La raison est toute bête : je ne connaissais pas le concept quand j'ai commencé. Comme le projet n'est pas encore trop avancé - il y a beaucoup de travail déjà abattu mais on doit en être à 35% à tout casser -, il est encore temps de changer ça.