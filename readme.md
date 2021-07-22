- [Analyse générale du projet](#analyse-générale-du-projet)
  - [Analyse fonctionnelle](#analyse-fonctionnelle)
  - [Couche métier](#couche-métier)
  - [Modélisation base de données](#modélisation-base-de-données)
- [Configuration de l'application](#configuration-de-lapplication)
  - [Utilisations de Packages](#utilisations-de-packages)
    - [Vich](#vich)
    - [Liip bundle thumbnails](#liip-bundle-thumbnails)
- [Système d'authentification](#système-dauthentification)
    - [Authentification system](#authentification-system)
- [Difficultés rencontrées](#difficultés-rencontrées)
- [Point à retravailler](#point-à-retravailler)
  - [](#)

# Analyse générale du projet
Un site collaboratif de recettes vegan, végétarienne, pescovégétarien.



L'application permet à ce stade de voir et partager des recettes si on le souhaite.

## Analyse fonctionnelle

Une application avec :
- un système de login avec des USERS.
- un espace privé qui affiche les recettes et propose des actions pour :
  - créer une recette
  - modifier une recette
  - voir les détails d'une recette
  - supprimer une recette
  
- Compréhensible voire dicté pour le client.
- Peut donner lieu à un Use Case UML.  
 ![UseCaseUML](usecase.png) 

## Couche métier
- dégager les types de données
- Ici : 
    1. Recette
    2. Catégories 
    3. Menus
    4. Picture
    5. User

## Modélisation base de données
- Un diagrammme de classe UML basé sur l'analyse fonctionnelle.
- Nous ici, on va créer un diagramme MySQLWB.  
 ![Modélisation base donnée](MySQLWB.png) 


# Configuration de l'application 
1. database 
   
   ```bash
   symfony console doctrine:database:create
   # faire la connexion avec la base de données
    DATABASE_URL="mysql://root:@127.0.0.1:3306/db_projet_symfony"
   ```
2. les entités Recette et Catégories et leur relation
   ```bash
   symfony console make:entity Recipe #(propriétés name, ingredients, instructions, cook_time, createdAt, accroche)
   symfony console make:entity Category #(name)
   symfony console make:entity Menu #(name)
   symfony console make:entity Picture #(name, VichBundle)
   symfony console make:entity User #(username, email, password)

   ```

## Utilisations de Packages
#
### Vich 
  Utilisation du package Vich Uploader afin de pouvoir mettre en place l'upload d'image sur mon application, notament sur pendant la création d'une recette. Les fichers s'enregistrent directement dans un dossier d'upload.


#
### Liip bundle thumbnails
 Utilisation du package Liip bundle thumbnails afin de pouvoir obtenir l'image d'une recette en thumbnail de taille d'une taille spécifique.

#

# Système d'authentification

### Authentification system


1. Authentification system



# Difficultés rencontrées

- Le système d'authentification 


# Point à retravailler 
## 
  - Mise en place d'un système de confirmation d'email, afin de pouvoir ajouter un point de sécurité.
  - Mise en place d'un système de modération pour pouvoir vérifier la conformité de chaque recette.
  - Système d'envoi de email afin de pouvoir modifier son mot de passe.
  - retravailler la mise en page du texte des recettes.