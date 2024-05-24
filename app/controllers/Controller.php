<?php 
declare(strict_types=1);
namespace blog\controllers;
class Controller
{

  public function views($view, $data = []){
    extract($data);
    require_once  __DIR__. '../../../public/views/' . $view . '.php';
  }
}
