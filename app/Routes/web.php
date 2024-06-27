<?php
declare(strict_types=1);
// 

use blog\controllers\Controller;
use blog\controllers\dashboard\AdminController;
use blog\controllers\HomeController;
use blog\controllers\login\LoginController;
use blog\controllers\posts\PostController;
use blog\controllers\students\StudentController;
use blog\Routes\core\App;
use blog\Routes\core\Router;
use blog\Routes\core\Routes;
use blog\services\auth\Middleware;

$router = new Router();

$router->get('/', HomeController::class, 'index')->name('home');
$router->get('/posts/index', PostController::class, 'index')->name('posts.index');
$router->get('/posts/show/{id}', PostController::class, 'show')->name('posts.show');
$router->get('/posts/create', PostController::class, 'create')->middleware([new Middleware(), 'requireLoggedIn'])->name('posts.create');
$router->get('/posts/update/{id}', PostController::class, 'edit')->middleware([new Middleware(), 'requireLoggedIn'])->name('posts.edit');// show data
$router->put('/posts/edit', PostController::class, 'update')->middleware([new Middleware(), 'requireLoggedIn'])->name('posts.update');// update data
$router->post('/posts/store', PostController::class, 'store')->name('posts.store');
$router->delete('/posts/delete/{id}', PostController::class, 'destroy')->middleware([new Middleware(), 'requireLoggedIn'])->name('posts.delete');
// Login routes
$router->get('/login/login', LoginController::class, 'index')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.index');
$router->post('/login/login', LoginController::class, 'login')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.login');
$router->post('/login/logout', LoginController::class, 'logout')
       ->name('logout');
// ---------------Admin route
$router->get('/dashboard/admin', AdminController::class, 'index')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.admin');
$router->get('/dashboard/show', AdminController::class, 'show')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.show');
// ---------------Student route
$router->get('/students/index', StudentController::class, 'index')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.index');
$router->get('/students/show', StudentController::class, 'show')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.show');
$router->get('/students/create', StudentController::class, 'create')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.create');
$router->post('/students/store', StudentController::class, 'store')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.store');
$router->delete('/students/destroy/{id}', StudentController::class, 'destroy')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.destroy');
// ---------------end
$app = new App($router);
Routes::run($app);

