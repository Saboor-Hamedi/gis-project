<?php

namespace blog\Routes;

class App
{
  protected $routes = [];

  public function addRoute(string $method, $route, $controller, $action = 'index')
  {
    $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
  }

  // show
  public function get($route, $controller, $action = 'index')
  {
    $this->addRoute('GET', $route, $controller, $action);
  }

  // store
  public function post($route, $controller, $action = 'index')
  {
    $this->addRoute('POST', $route, $controller, $action);
  }
  // update
  public function update($route, $controller, $action = 'update')
  {
    $this->addRoute('PUT', $route, $controller, $action);
  }
  // delete
  public function delete($route, $controller, $action = 'destroy')
  {
    $this->addRoute('DELETE', $route, $controller, $action);
  }

  public function run()
  {
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Loop through routes to find a match
    foreach ($this->routes[$httpMethod] as $route => $routeInfo) {
      // Replace placeholders with regex
      $regexRoute = preg_replace('#/{([^/]+)}#', '/([^/]+)', $route);
      $regexRoute = str_replace('/', '\/', $regexRoute);
      $regexRoute = '/^' . $regexRoute . '$/';

      // Check if the URI matches the route
      if (preg_match($regexRoute, $uri, $matches)) {
        // If matched, extract parameters
        array_shift($matches); // Remove the first element which is the full match
        $this->executeControllerAction($routeInfo, ...$matches);
        return;
      }
    }
    // No route matched, return 404
    $this->pageNotFound();
   
  }
  public function pageNotFound($code = 404){
    http_response_code($code);
    require_once __DIR__ . '/404.php';
  }
  

  public function executeControllerAction($routeInfo, ...$args)
  {
    $controllerName = $routeInfo['controller'];
    if (!class_exists($controllerName)) {
      $this->pageNotFound();
      return;
    }
    $controller = new $controllerName();
    if (!method_exists($controller, $routeInfo['action'])) {
      $this->pageNotFound();
      return;
    }

    $action = $routeInfo['action'];
    call_user_func_array([$controller, $action], $args);
  }
}
