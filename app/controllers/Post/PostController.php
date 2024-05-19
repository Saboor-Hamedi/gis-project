<?php
namespace blog\controllers\Post;
use blog\controllers\Controller;

class PostController extends Controller
{
  public function index()
  {
    $this->views('post/index');
  }
  public function show($id){
    dd($id);
  }
}
