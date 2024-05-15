# Dynastie Qin

## Informations générales

Auteurs :
- Rémi TRAN VAN BA
- Steven ARNAUD

Stacks :
- PHP
- JS
- HTML/CSS
- Twig

## Lancer le site en local

Lancer le docker-compose avec la commande : 
```bash
docker compose up
```

Le site sera accessible à l'adresse http://localhost:8000

### Pgadmin

Le pgadmin, quant à lui, à l'adresse http://localhost:5050
Identifiant : admin@admin.com
Mot de passe : root

Il faut ensuite ajouter le serveur de base de données suivant :

Host : postgres
Nom de la base : mydatabase
Identifiant : myuser
Mot de passe : mypassword

## Structure

Notre site se base sur une architecture MVC. Le routage est effectué à l'aide d'un routeur développé manuellement et basé sur les attributs PHP 8.

### Routage automatique

Le routage dynamique se fait par le biais d'attributs. Par exemple:

```php
#[Route('/filter', ['GET','POST'], 'filter')]
public function filter(){
```

Les paramètres sont les suivants :
- Point de terminaison
- Méthodes HTTP autorisées
- Fonction à appeler

### Controllers

Nous avons fait le choix de regrouper les controllers par aspect métier. Ainsi, nous avons les controllers suivants :
- DefaultController (route la route par défaut)
- APIController (controller dédié à l'API)
- PathologyController
- SessionController

Ceux-ci interrogent les modèles afin de récupérer les données depuis la base de données et enfin chargent les templates twig.

### Models

Nos modèles sont également orientés métier avec une classe PHP correspondant à chaque table de la BDD. Chacune de ces classes s'accompagne de sa classe Manager chargée de regrouper les traitements autour de la base de donnée.

### Views

Enfin, les vues sont construites sous moteur de template Twig.
