# Documentation

# Création de la base de donnée

La création de la base de données s'est faite après analyse du fichier csv à importer. J'ai reporté les entêtes et ajouté
deux colonnes une pour l'étagère et une autre pour la rangé

Voici la structure de la base de données dans Symfony


| Field      |     Type    |   Null | Key |
| ------------- |: -------------: | ---------: |---------: |
| id            |        int(11)  |      No |PRI |
| title       | varchar(255) | YES  |     | NULL    |                
| name        | varchar(255) | YES  |     | NULL    |                
| firstname   | varchar(255) | YES  |     | NULL    |                
| editor      | varchar(255) | YES  |     | NULL    |                
| book_format | varchar(255) | YES  |     | NULL    |                
| type        | varchar(255) | YES  |     | NULL    |                
| section     | varchar(255) | YES  |     | NULL    |                
| shelf       | varchar(1)   | YES  |     | NULL    |                
| row         | varchar(1)   | YES  |     | NULL    |

                
Elle est générée via l'entité Library
Les champs sheld et row sont codés sur un seul caractère pour coller au mieux au modèle initial
sans utilisation surperflue de ressource

# Import des données

Pour importer les données un fichier Command à été créer (src/Command) qui peut être appeller via la commande suivante :

> php bin/console app:import-data

En exécutant cette commande un message demande la confirmation de l'import (si le fichier à été trouvé par défaut il va 
le chercher dans var/csv) à confirmer en tapant y et entrée.

Toutes les lignes du csv sont alors importés. Vous pouvez indiquer un autre chemin du fichier à importer en utilisant 
l'option --path. Exemple si le fichier se trouve à la racine du repertoire public et se nomme dataset.csv

> php bin/console app:import-data --path="public/dataset.csv"

## Affectation des étagères et rangée

On dispose de 8 étagères et 6 rangées afin de classifier les oeuvres lors de l'import j'ai décidé de suivre le model suivant :

26000 enregistrements pour 8 étagères, cela fait 3200 oeuvres par étagères et 541 par rangé en répartissant équitablement.
En fonction du nombre d'enregistrements trouvé j'affecterai les étagères

Les deux dernières étagères contiendront les disques, cassettes audios et DVD et console de jeux et le jouet ; les sections seront répartie ainsi :
1:jeunesse,2:DVD jeunesse,3:support d'animation,4:Discotheque,5:DVD adulte,6:Adulte (5000 enregistrements)

La rangée 6 de l'étagère H contiendra les ouvrages qui ne correspondent à aucune règle

Les étagères D,E,F contiendront tous les ouvrages dédiés à la jeunesse. On les classera du plus facile à lire au plus difficile.
Les livres étant en nombre plus important on les répartira sur 5 rangées
1:livre DVD,livre CD,Livre lu,Revues,2&3&45&6: Livre(s) (9000 enregistrements)

Les étagères A,B,C contiendront les livres pour Adultes. La répartition
On suivra la même répartition que précédemment :
2&3&4&5&6 : Livre(s) 1:autres

# Api Plateform

Afin de mettre en place le CRUD j'utilise Api platform qui me permet de mettre en place une API avec une documentation 
rapidement. Grace à un système d'annotation sur les entités les opérations get, post, put, patch et delete sont implémentées

## Mise en place du soft delete

La mise en place du soft delete s'est fait avec Gedmo. Il a fallu rajouté quelques lignes de paramètrage dans le fichier
doctrine.yml et service.yml pour activer respectivement le filtre permettant de ne pas inclure les lignes supprimées et
activer le listener permettant de surcharger la fonction remove de Symfony.

## Mise en place du système de recherche

Via Api platform on peut implémenter la recherche en fonction des champs, mais aussi le tri des données grâce à des
annotations sur l'entité (voir ApiFilter)

## Configuration supplémentaire 

### PSR-2

Afin de respecter les règles PSR-2 j'ai paramétré PHPStorm pour qu'il se charge des règles les plus simples. L'indentation
, les espaces dans les fonctions.... J'ai dû m'assurer manuellement d'autre règles comme la ligne vide à la fin d'un fichier
PHP, nommage des classes et des fonctions... En bref tout ce que l'IDE ne faisait pas automatiquement.
