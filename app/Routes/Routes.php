<?php
namespace blog\Routes;
use blog\Routes\App;

class Routes
{
  public function __construct(App $app) {
    $app->run();
  }
}
