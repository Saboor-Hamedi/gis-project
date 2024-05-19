<?php

use blog\controllers\HomeController;
use blog\controllers\Post\PostController;
use blog\Routes\App;
use blog\Routes\Routes;
$app = new App();
$app->get('/', HomeController::class, 'index');
$app->get('/create', HomeController::class, 'create');
$app->post('/store', HomeController::class, 'store');
$app->get('/post/index', PostController::class, 'index');
$app->get('/post/show/{id}', PostController::class, 'show');
$route = new Routes($app);

