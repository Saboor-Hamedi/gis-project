<?php

declare(strict_types=1);

use blog\controllers\dashboard\AdminController;
use blog\controllers\HomeController;
use blog\controllers\login\LoginController;
use blog\controllers\students\StudentController;
use blog\Routes\core\App;
use blog\Routes\core\Router;
use blog\Routes\core\Routes;
use blog\services\auth\Middleware;

$router = new Router();
// --------------- Post
$router->get('/', HomeController::class, 'index')->name('home');
$router->get('/posts/show/{id}', HomeController::class, 'show')->name('posts.show');
// ---------------Login routes
$router->get('/login/login', LoginController::class, 'index')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.index');
$router->post('/login/login', LoginController::class, 'login')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.login');
$router->post('/login/logout', LoginController::class, 'logout')->name('logout');
// ---------------Admin route
$router->get('/dashboard/admin', AdminController::class, 'index')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.admin');
$router->get('/dashboard/show/{id}', AdminController::class, 'show')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.show');
$router->get('/dashboard/update/{id}', AdminController::class, 'update')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.update');
$router->put('/dashboard/edit', AdminController::class, 'edit')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.edit');
$router->get('/dashboard/create', AdminController::class, 'create')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.create');
$router->post('/dashboard/store', AdminController::class, 'store')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.store');
$router->delete('/dashboard/destroy/{id}', AdminController::class, 'destroy')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.destroy');
// ---------------Student route
$router->get('/students/index', StudentController::class, 'index')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.index');
$router->get('/students/show/{id}', StudentController::class, 'show')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.show');
$router->get('/students/update/{id}', StudentController::class, 'update')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.update'); // show the data
$router->put('/students/edit', StudentController::class, 'edit')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.edit'); // update the data
$router->get('/students/create', StudentController::class, 'create')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.create');
$router->post('/students/store', StudentController::class, 'store')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.store');
$router->delete('/students/destroy/{id}', StudentController::class, 'destroy')->middleware([new Middleware(), 'requireLoggedIn'])->name('students.destroy');
// ---------------end
$app = new App($router);
Routes::run($app);
