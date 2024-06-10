<?php
declare(strict_types=1);
// 
use blog\controllers\HomeController;
use blog\controllers\posts\PostController;
use blog\Routes\core\App;
use blog\Routes\core\Router;
use blog\Routes\core\Routes;
$router = new Router();
$router->get('/', HomeController::class, 'index')->name('home');
$router->get('/posts/index', PostController::class, 'index')->name('posts.index');
$router->get('/posts/show/{id}', PostController::class, 'show')->name('posts.show');
$router->get('/posts/create', PostController::class, 'create')->name('posts.create');
$router->put('/posts/edit', PostController::class, 'update')->name('posts.update');
$router->get('/posts/update/{id}', PostController::class, 'edit')->name('posts.edit');
$router->post('/posts/store', PostController::class, 'store')->name('posts.store');
$router->delete('/posts/delete/{id}', PostController::class, 'destroy')->name('posts.delete');
$app = new App($router);
Routes::run($app);

