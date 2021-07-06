<?php

require '../src/config.php';
require '../vendor/autoload.php';

$route = new \Base\Route();
$route->add('/', \App\Controller\Login::class);

$app = new \Base\Application($route);
$app->run();