<?php

declare(strict_types=1);

namespace blog\Routes\core;

class Routes
{
    public string $method;
    public string $uri;
    public string $controller;
    public string $action;
    public ?string $name = null;
    protected Router $router;
    protected array $middlewares = [];

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

    /**
     * Attach middleware to the route.
     */
    public function middleware(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        $this->router->middlewares[$this->uri] = $this->middlewares;
        return $this;
    }

    public static function run(App $app): void
    {
        $app->run();
    }
}
