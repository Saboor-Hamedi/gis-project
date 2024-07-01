<?php

declare(strict_types=1);

namespace blog\Routes\core;

use blog\controllers\Controller;
use blog\services\ResponseCode;

class App
{
  use ResponseCode;

  protected Router $router;

  public function __construct(Router $router)
  {
    $this->router = $router;
  }

  /**
   * Get the HTTP request method.
   */
  private function getRequestMethod(): string
  {
    $httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    if (isset($_POST['_method'])) {
      $httpMethod = strtoupper($_POST['_method']);
    }
    return $httpMethod;
  }

  /**
   * Get the request URI.
   */
  private function getRequestUri(): string
  {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
  }
  /**
   * Handle the HTTP request.
   */
  public function handleRequestData()
  {
    $httpMethod = $this->getRequestMethod();
    $uri = $this->getRequestUri();
    $this->handleRequest($httpMethod, $uri);
  }
  /**
   * Run the application.
   */
  public function run(): void
  {
    try {
      $this->handleRequestData();
    } catch (\Exception $e) {
      echo 'Semthing went wrong on route: ' . $e->getMessage();
    }
  }

  /**
   * Handle the request based on the HTTP method and URI.
   */
  protected function handleRequest(string $httpMethod, string $uri): void
  {

    $routeMatch = $this->router->match($httpMethod, $uri);

    if ($routeMatch === null) {
      $this->sendResponse(self::NOT_FOUND, 'Route not found, or check the folder name');
    }

    // Execute middlewares
    if (isset($routeMatch['middlewares'])) {
      foreach ($routeMatch['middlewares'] as $middleware) {
        call_user_func($middleware);
      }
    }

    if (isset($routeMatch['routeInfo']) && is_array($routeMatch['routeInfo'])) {
      $this->executeControllerAction($routeMatch['routeInfo'], ...($routeMatch['params'] ?? []));
    }
  }


  /**
   * Execute the controller action.
   */
  private function executeControllerAction(array $routeInfo, ...$args): void
  {
    if ($routeInfo['isClosure']) {
      $controller = $routeInfo['controller'];
      if ($controller instanceof \Closure) {
        $controller = $controller->bindTo(new Controller(), Controller::class);
      }
      $output = call_user_func_array($controller, $args);
      if (is_string($output)) {
        echo $output;
      }
      return;
    }

    $controller = $this->createControllerInstance($routeInfo['controller']);
    if (!$controller) {
      $this->sendResponse(self::NOT_FOUND, "Controller not found.");
      return;
    }

    $action = $routeInfo['action'];
    if (!method_exists($controller, $action)) {
      $this->sendResponse(self::METHOD_NOT_ALLOWED, "The requested action '{$action}' is not allowed.");
      return;
    }

    $this->callActionOnController($controller, $action, $args);
  }

  /**
   * Create an instance of the controller.
   */
  private function createControllerInstance(string $controllerName): ?object
  {
    if (!class_exists($controllerName)) {
      return null;
    }
    return new $controllerName();
  }

  /**
   * Call the action method on the controller.
   */
  private function callActionOnController(object $controller, string $action, array $args): void
  {
    if (!method_exists($controller, $action)) {
      $this->sendResponse(self::METHOD_NOT_ALLOWED, "The requested action '{$action}' is not allowed.");
      return;
    }
    call_user_func_array([$controller, $action], $args);
  }
}
