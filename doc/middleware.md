# Middleware Setup Guide
This document provides a detailed explanation of how to set up and use middleware in your application to manage user authentication and route access control.
### Middleware Purpose
Middleware is used to filter HTTP requests entering your application. In this setup, we use middleware to:
1. **Require authentication** for certain routes.
2. **Prevent logged-in users** from accessing the login page.
### Middleware Class
The `Middleware` class defines two main methods: `requireLoggedIn` and `preventBackWhenLoggedIn`.
```php 
<?php

namespace blog\services\auth;

use blog\services\Session;

class Middleware
{
  protected $session;

  public function __construct()
  {
    $this->session = new Session();
  }

  public function requireLoggedIn()
  {
    if (!$this->session->has('user_id')) {
      $this->redirect('/login/login');
    }
  }

  public function preventBackWhenLoggedIn()
  {
    if ($this->session->has('user_id')) {
      $this->redirect('/dashboard/admin');
    }
  }

  public function redirect(string $url, int $statusCode = 302): void
  {
    header('Location: ' . $url, true, $statusCode);
    exit();
  }
}

```
### Route Definitions
In `web.php`, we define the routes and apply the middleware to the appropriate routes.
Here is my `CRUD` example:
```php 
<?php

declare(strict_types=1);

use blog\controllers\dashboard\AdminController;
use blog\controllers\HomeController;
use blog\controllers\login\LoginController;
use blog\controllers\posts\PostController;
use blog\Routes\core\App;
use blog\Routes\core\Router;
use blog\Routes\core\Routes;
use blog\services\auth\Middleware;

$router = new Router();

// Home route with middleware to prevent logged-in users from accessing the login page
$router->get('/', HomeController::class, 'index')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('home');

// Post routes
$router->get('/posts/index', PostController::class, 'index')->name('posts.index');
$router->get('/posts/show/{id}', PostController::class, 'show')->name('posts.show');

// Middleware to require user to be logged in for creating, updating, and deleting posts
$router->get('/posts/create', PostController::class, 'create')->middleware([new Middleware(), 'requireLoggedIn'])->name('posts.create');
$router->get('/posts/update/{id}', PostController::class, 'edit')->name('posts.edit'); // Show data
$router->put('/posts/edit', PostController::class, 'update')->name('posts.update'); // Update data
$router->post('/posts/store', PostController::class, 'store')->name('posts.store');
$router->delete('/posts/delete/{id}', PostController::class, 'destroy')->name('posts.delete');

// Login routes with middleware to prevent logged-in users from accessing the login page
$router->get('/login/login', LoginController::class, 'index')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.index');
$router->post('/login/login', LoginController::class, 'login')->middleware([new Middleware(), 'preventBackWhenLoggedIn'])->name('login.login');
$router->post('/login/logout', LoginController::class, 'logout')->name('logout');

// Dashboard route with middleware to require user to be logged in
$router->get('/dashboard/admin', AdminController::class, 'index')->middleware([new Middleware(), 'requireLoggedIn'])->name('dashboard.admin');

// Create the application and run it
$app = new App($router);
Routes::run($app);

```
### Explanation

1.  **Session Management**: The `Session` class handles starting sessions, setting and getting session values, and managing session states.
    
2.  **Middleware**:
    
    -   `requireLoggedIn`: Ensures that only logged-in users can access certain routes. If the user is not logged in, they are redirected to the login page.
    -   `preventBackWhenLoggedIn`: Prevents logged-in users from accessing the login page. If they try to access it, they are redirected to the dashboard.
3.  **Route Definitions**: Routes are defined and middleware is applied to specific routes to control access:
    
    -   **Home Route**: Prevents logged-in users from accessing the login page.
    -   **Post Routes**: Ensures that only logged-in users can create posts.
    -   **Login Routes**: Prevents logged-in users from accessing the login page.
    -   **Dashboard Route**: Ensures that only logged-in users can access the dashboard.

By following this setup, you can manage user access effectively and ensure that your application behaves as expected regarding user authentication and route access control.
