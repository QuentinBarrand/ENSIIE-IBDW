<?php
require '../flight/Flight.php';

include_once 'config.php';

include_once 'controllers/Authentification.php';
include_once 'controllers/Choristes.php';
include_once 'controllers/Evenements.php';

// On stocke les détails de l'utilisateur dans la variables d'instance 'user' de Flight
Flight::set('user', Authentification::getUserDetails());

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
			'user' => Flight::get('user'),
			'activePage' => 'home'
			), 
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


Flight::start();
