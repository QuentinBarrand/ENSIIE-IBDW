<?php
require '../flight/Flight.php';

include_once 'config.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::start();
?>
