<?php

date_default_timezone_set('UTC');

// Ecriture des erreurs dans les logs du serveur web
Flight::set('flight.log_errors', true);

// Informations de connexion à la base de données
Flight::set('postgres.host',     '');
Flight::set('postgres.database', '');
Flight::set('postgres.user',     '');
Flight::set('postgres.password', '');

