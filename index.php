<?php
require '../flight/Flight.php';

include_once 'config.php';

include_once 'lib/Authentification.php';
include_once 'lib/Choristes.php';
include_once 'lib/Evenements.php';

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


// Choristes
Flight::route('/choristes', function() {
	Choristes::get();
});

Flight::route('/choristes/new', function() {
    echo "Formulaire d'ajout d'un choriste";
});

// Events
Flight::route('/evenements', function() {
    Evenements::get();
});

Flight::route('/evenements/new', function() {
    echo "Formulaire d'ajout d'un évènement";
});


// Affichage de la page de contact
Flight::route('GET /login', function() {
    Authentification::displayLoginPage();
});

// En post, cette route permet d'authentifier un utilisateur
Flight::route('POST /login', function() {
    Authentification::authenticate();
});


Flight::start();
