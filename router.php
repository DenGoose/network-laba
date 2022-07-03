<?php
$router = new \Silex\Application();

$router->get('/', [\App\Controller\IndexController::class, 'exec']);
$router->post('/', [\App\Controller\IndexController::class, 'calc']);

$router->get('/result/', [\App\Controller\ResultController::class, 'exec']);

$router->run();