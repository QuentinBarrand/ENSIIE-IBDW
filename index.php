<?php
require '../flight/Flight.php';

include_once 'config.php';

// Accueil
Flight::route('/', function(){
    echo "Bienvenue dans l'application !";
});


// Choristes
Flight::route('/choristes', function(){
    echo 'Liste des choristes';
});

Flight::route('/choristes/new', function(){
    echo "Formulaire d'ajout d'un choriste";
});

// Events
Flight::route('/evenements', function(){
    echo 'Liste des evenements';
});

Flight::route('/evenements/new', function(){
    echo "Formulaire d'ajout d'un évènement";
});


Flight::start();
