# exempleDoctrine
Projet personnel de mise en place d'un panier de type e-commerce.  
> ORM (Object Relationnal Mapping)

## __Contexte:__  
L'objectif de ce projet consiste à gérer l'__ajout__ et la __suppression__ de __produits__ dans un __panier__ via __PHP__ et __Symfony__.  
Pour ce faire, dans un  premier temps, j'ai créé une base de données __SQL__ contenant une table de produits (instruments de musique) 
en utilisant __Doctrine__, l'ORM par défaut de __Symfony__. Ensuite, j'ai généré un __CRUD__ sur cette table pour pouvoir y accéder et manipuler ses données. Pour finir, j'ai géré l'affichage des produits  et la création du panier avec __Ajax__, __jQuery__ et __JSON__.

## __Phase 1:__  
Création de la base de données dans HeidiSQL via Doctrine.

<img src="/database/database.png" />

## __Phase 2:__
Affichage de la liste des produits et création du panier.

<img src="cart.gif" />
