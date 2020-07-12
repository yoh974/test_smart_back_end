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
