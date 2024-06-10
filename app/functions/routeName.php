<?php

use blog\Routes\core\Router;

function url(string $routeName): string
{
  $route = new Router();
  $generatedUrl = $route->route($routeName);
  echo $generatedUrl;
  return $generatedUrl;
}
