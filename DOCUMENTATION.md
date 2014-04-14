# Structure du projet
Sur [notre dépôt Git](https://github.com/QuentinBarrand/ENSIIE-IBDW),

* les fichiers du framework [Flight](http://flightphp.com/) sont inclus dans le répertoire `lib`. Il est inutile d'essayer comprendre le contenu de ces fichiers;
* les contrôleurs, qui font les requêtes dans la base de données et les traitements sur ces données, sont dans `controllers`;
* les vues (templates HTML qui contiennent les données envoyées par les contrôleurs) sont dans `views`;
* les feuilles de style CSS sont dans `css` et les scripts JavaScript dans `js`;
* la documentation est dans `doc`.

# Quel est le cycle de vie d'une requête ?
L'étude du cycle de vie d'une requête va nous permettre de comprendre à peu près l'ensemble des fonctionnalités de Flight que nous utilisons.

## Réécriture d'URL
On prend l'exemple du cas où l'application est installée à la racine du serveur web (typiquement `/var/www/` sur Ubuntu ou Debian comme on a à l'école).  
Sans entrer dans les détails, il faut savoir que tout requête du genre `http://localhost/choristes/new` sera redirigée par le serveur HTTP Apache vers `http://localhost/index.php` grâce à une fonctionnalité appelée "URL rewriting" (ou réécriture d'URL en français).  
En opérant cette redirection, Apache fournit aussi à `index.php` l'URL qui était demandée initialement (`/choristes/new`) dans une variable. Pour comprendre comment cette variable est utilisée, il faut étudier `index.php`.

## `index.php`
Le fichier est disponible en entier [dans le dépôt](https://github.com/QuentinBarrand/ENSIIE-IBDW/blob/master/index.php). Regardons-en certaines parties :

### Import des fonctionnalités de Flight
```php
require 'lib/flight/Flight.php';
```  
En utilisant le mot-clé `require`, on précise que l'import de ce fichier est obligatoire pour lancer l'application.

### Import de nos classes à nous
```php
include_once 'config.php';

include_once 'controllers/Authentification.php';
include_once 'controllers/Choristes.php';
include_once 'controllers/Evenements.php';
include_once 'controllers/Programme.php';
include_once 'controllers/Inscriptions.php';
```  
On inclut nos fichiers à nous (on va les utiliser dans un instant !).

### Simplification de la connexion à PostGreSQL
```php
// On stocke un objet db qui contient la connexion à la base de données
Flight::register('db', 'PDO', array('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'),
    Flight::get('postgres.user'),
    Flight::get('postgres.password')));
```
Cette ligne nous permet d'utiliser `$db = Flight::db();` à chaque fois que l'on veut utiliser une nouvelle connexion PDO. Pratique !  
Les variables qui contiennent les valeurs de connexion à PostGreSQL sont importées de `config.php`. Elles sont stockées dans les variables d'environnement de Flight.

### Authentification
```php
// On stocke les détails de l'utilisateur dans la variables d'instance 'user' de Flight
Flight::set('user', Authentification::getUserDetails());
```  
Ici, l'idée est de stocker dans la variable d'environnement `user` de Flight les données de l'utilisateur qui visite la page. Vous pouvez aller voir la méthode `getUserDetails()` de la classe `Authentification` dans le fichier `controllers/Authentification.php`
pour comprendre comment ça marche, en gros :

* lors de la connexion d'un utilisateur, on stocke sur son PC un cookie qui contient son `login`;
* à chaque fois qu'il fait une requête sur une page, ce cookie est lu par l'application et une requête est faite dans la base pour récupérer les détails de son compte (sa responsabilité, son nom, son prénom...)
* lorsqu'il se déconnecte, le champ `login` du cookie est mis à `NULL`. 

### Définition des routes
Comme on l'a vu plus haut, le fichier `index.php` reçoit toutes les requêtes et dispose de l'URL qui était initialement demandée.
```php
/*
 * Choristes
 */

// Affichage de la liste des choristes
Flight::route('/choristes', function() {
    Choristes::get();
});

// Affichage du formulaire d'ajout d'un choriste
Flight::route('GET /choristes/new', function() {
    echo "Formulaire d'ajout d'un choriste";
});

// Traitement de la requête issue du formulaire
Flight::route('POST /choristes/new', function() {
    echo "Traitement de la requête issue du formulaire";
});
```  
Vous pouvez voir que pour l'URL `/choristes`, on déclenche l'appel à la méthode `get()` de la classe `Choristes`. C'est aussi simple que ça. On verra juste après comment cette méthode génère un document HTML qui est rendu sur le navigateur du visiteur.  
Petite subtilité : une même URL peut recevoir une requête en `GET` et en `POST`. C'est le cas pour `/choristes/new`. Typiquement, toute requête GET se verra renvoyer le formulaire d'inscription, alors que l'utilisation de la méthode `POST` permettra de transmettre les données de ce formulaire. Un tel comportement est déjà implémenté pour la route `/login`.

### Lancement de l'application
A la fin du fichier (après la définition de l'ensemble des routes), on appelle `Flight::start();` qui lance l'application et appelle effectivement la méthode correspondant à la route de la requête.

## Contrôleur et vue
Prenons pour exemple la méthode `get()` de la classe `Choristes`, dans le fichier `controllers/Choristes.php`. Cette méthode se charge de l'affichage des choristes.  
On ne s'étendra pas sur la connexion à la base de données puisque c'est du PDO classique (mis à part qu'il est dans un `try`-`catch` pour gérer les erreurs.  
Si tout va bien, à la fin de la deuxième structure `try`-`catch`, on a dans `$data['content']` l'ensemble des résultats de la requête et dans `$data['success]` la valeur `true`. On va pouvoir envoyer cette variable à la vue, mais d'abord :

```php
// Header
Flight::render('header.php',
    array(
        'title' => 'Liste des choristes'
        ),
        'header');
```  
On génère ici la variable `$header` par l'interprétation du fichier `views/header.php`. Lors de cette interprétation, la variable `$title` contiendra la chaîne de caractères `'Liste des choristes'`.

```php
// Navbar
Flight::render('navbar.php',
    array(
        'activePage' => 'choristes'
    ),
    'navbar');

// Footer
Flight::render('footer.php',
    array(),
    'footer'); 
```  
Idem  pour les variables `$navbar` et `$footer`. Ensuite, lorsque l'on appelle la génération du layout (fichier ``views/ChoristesLayout.php`, on pourra utiliser `echo $header;`.

```php
// Finalement on rend le layout
if($data['success'])
    Flight::render('ChoristesLayout.php', array('data' => $data));
else
    Flight::render('ErrorLayout.php', array('data' => $data));

```  
On note que pour un traitement des erreurs un peu plus agréable, si `$data['success']` n'est pas égal à `true`, on rend le layout de la page d'erreur.  
C'est donc la vue `views/ChoristesLayout.php` qui se charge de mettre en forme le contenu de la variable `$data['content']`.

## Pour aller plus loin
La [documentation de Flight](http://flightphp.com/learn) est bien faite, synthétique et avec des exemples.

# C'est fini !
Si vous avez la moindre question, un mail ! Il n'y a pas de questions idiotes.  
Si vous avez trouvé une meilleure façon d'expliquer comment ça fonctionne, n'hésitez pas à éditer et commiter ce fichier !
