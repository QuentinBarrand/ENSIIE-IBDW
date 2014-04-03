<?php

require_once __DIR__.'/../vendor/autoload.php';

include_once 'config.php';

$app = new Silex\Application();

$app->get('/', function() {
    return 'Hello World!';
});

$app->run();
