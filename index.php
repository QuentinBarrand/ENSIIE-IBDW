<?php
require 'lib/flight/Flight.php';

include_once 'config.php';

include_once 'controllers/Authentification.php';
include_once 'controllers/Choristes.php';
include_once 'controllers/Evenements.php';
include_once 'controllers/Programme.php';

// On stocke les détails de l'utilisateur dans la variables d'instance 'user' de Flight
Flight::set('user', Authentification::getUserDetails());

Flight::register('db', 'PDO', array('pgsql:host='. Flight::get('postgres.host') .';dbname='. Flight::get('postgres.database'), 
                Flight::get('postgres.user'), 
                Flight::get('postgres.password')));

// Accueil
Flight::route('/', function(){
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
Flight::route('GET /choristes/new', function() {
    echo "Formulaire d'ajout d'un choriste";
});

// Traitement de la requête issue du formulaire
Flight::route('POST /choristes/new', function() {
    echo "Traitement de la requête issue du formulaire";
});

/*
 * Evènements
 */

// Affichage de la liste des évènements
Flight::route('/evenements', function() {
    Evenements::get();
});

// Affichage du formulaire d'ajout d'un évènement
Flight::route('GET /evenements/new', function() {
    echo "Formulaire d'ajout d'un évènement";
});

// Traitement de la requête issue du formulaire
Flight::route('POST /evenements/new', function() {
    echo "Traitement de la requête issue du formulaire";
});

/*
 * Programme
 */

// Affichage de la liste des oeuvres
Flight::route('/programme', function() {
    Programme::get();
});

// Affichage de la liste des oeuvres
Flight::route('/programme/new', function() {
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

Flight::map('notFound', function(){
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

Flight::start();
