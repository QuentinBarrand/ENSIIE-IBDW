<?php
require 'lib/flight/Flight.php';

include_once 'config.php';

include_once 'controllers/Authentification.php';
include_once 'controllers/Choristes.php';
include_once 'controllers/Evenements.php';
include_once 'controllers/Programme.php';
include_once 'controllers/Inscriptions.php';

// On stocke un objet db qui contient la connexion à la base de données
Flight::register('db', 'PDO', array('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'),
    Flight::get('postgres.user'),
    Flight::get('postgres.password')));

// On stocke les détails de l'utilisateur dans la variables d'instance 'user' de Flight
Flight::set('user', Authentification::getUserDetails());

// Accueil
Flight::route('/', function() {
    // Header
    Flight::render('header.php',
        array(
            'title' => 'Accueil'
            ), 
        'header');

    // Navbar
    Flight::render('navbar.php',
        array(
            'activePage' => 'home'), 
        'navbar');

    // Footer
    Flight::render('footer.php',
        array(), 
        'footer');      

    // Finalement on rend le layout
    Flight::render('HomeLayout.php', array());
});


/*
 * Choristes
 */

// Affichage de la liste des choristes
Flight::route('/choristes', function() {
    Choristes::get();
});

// Affichage du formulaire d'ajout d'un choriste
Flight::route('GET /choristes/nouveau', function() {
    Choristes::displayChoristeForm();
});

// Traitement de la requête issue du formulaire
Flight::route('POST /choristes/nouveau', function() {
    Choristes::subscribe();
});

/*
 * Compte
 */

// Affichage des informations du compte de l'utilisateur
Flight::route('GET /choristes/account', function() {
    Choristes::displayAccountForm();
});

// Traitement de la requête issue du formulaire de modification du compte
Flight::route('POST /choristes/account', function() {
    Choristes::submitAccountForm();
});

/*
 * Inscriptions
 */

// Affichage des inscriptions à valider
Flight::route('/inscriptions', function() {
    Inscriptions::get();
});


// Validation d'une inscription
Flight::route('/inscriptions/validation/@id', function($id) {
    Inscriptions::validate($id);
});


/*
 * Evènements
 */

// Affichage de la liste des évènements
Flight::route('GET /evenements', function() {
    Evenements::get();
});

// Affichage du formulaire d'ajout d'un évènement
Flight::route('GET /evenements/nouveau', function() {
    Evenements::displayEventForm();
});

// Mise à jour de la liste des évènements (présence aux évènements)
Flight::route('POST /evenements', function() {
    Evenements::updateEvents();
});

// Traitement de la requête issue du formulaire
Flight::route('POST /evenements/nouveau', function() {
    Evenements::add();
});

// Traitement de la requête issue du formulaire
Flight::route('POST /oeuvre/nouveau', function() {
    Evenements::addOeuvre();
});

// Traitement de la requête issue du formulaire
Flight::route('POST /saison/nouveau', function() {
    Evenements::addSaison();
});

/*
 * Programme
 */

// Affichage de la liste des oeuvres
Flight::route('/programme', function() {
    Programme::get();
});

// Affichage de la liste des oeuvres
Flight::route('/programme/nouveau', function() {
    echo "Formulaire d'ajout d'une oeuvre";
});

/*
 * Login
 */

// Affichage de la page de contact
Flight::route('GET /login', function() {
    Authentification::displayLoginPage();
});

// En post, cette route permet d'authentifier un utilisateur à partir des données du formulaire de login
Flight::route('POST /login', function() {
    Authentification::authenticate();
});

Flight::route('/logout', function() {
    Authentification::logout();
});

/*
 * Erreurs
 */

Flight::map('notFound', function() {
    Flight::render('header.php',
        array(
            'title' => 'Page introuvable'
            ), 
        'header');

    // Navbar
    Flight::render('navbar.php',
        array(
            'activePage' => ''), 
        'navbar');

    // Footer
    Flight::render('footer.php',
        array(), 
        'footer');  

    $data['error'] = "La page demandée est introuvable.";
    Flight::render('ErrorLayout.php', array(
        'data' => $data));
});

Flight::map('forbidden', function() {
    Flight::render('header.php',
        array(
            'title' => 'Accès interdit'
            ),
        'header');

    // Navbar
    Flight::render('navbar.php',
        array(
            'activePage' => ''
            ),
        'navbar');

    // Footer
    Flight::render('footer.php',
        array(),
        'footer');

    $data['error'] = "Vous n'avez pas accès à cette page.";
    Flight::render('ErrorLayout.php', array(
        'data' => $data));
});

Flight::start();
