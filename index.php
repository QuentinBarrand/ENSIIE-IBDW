<?php
require '../flight/Flight.php';

include_once 'config.php';

include_once 'lib/Choristes.php';
include_once 'lib/Evenements.php';

// Accueil
Flight::route('/', function(){
    echo "Bienvenue dans l'application !";
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


Flight::start();
