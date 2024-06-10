<?php
declare(strict_types=1);
namespace blog\Routes\core;
use blog\Routes\core\App;
use blog\Routes\core\Router;
class Routes
{
    public string $method;
    public string $uri;
    public string $controller;
    public string $action;
    public ?string $name = null;
    protected Router $router;

    public function __construct(string $method, string $uri, string $controller, string $action, Router $router)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->action = $action;
        $this->router = $router;
    }

    /**
     * Set a name for the route.
     */
    public function name(string $name): self
    {
        $this->name = $name;
        $this->router->registerNamedRoute($this);
        return $this;
    }

    public static function run(App $app): void
    {
        $app->run();
    }
}
