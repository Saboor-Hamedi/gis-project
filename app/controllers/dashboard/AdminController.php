<?php
namespace blog\controllers\dashboard;
use blog\controllers\Controller;

class AdminController extends Controller{
  public function index(){
    $this->views('/dashboard/admin');
  }
}
