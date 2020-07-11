# Documentation

# Création de la base de donnée

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

## Mise en place du système de recherche

## Configuration supplémentaire 
