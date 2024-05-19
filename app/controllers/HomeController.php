<?php

namespace blog\controllers;
use blog\controllers\Controller;
use blog\model\PostModel;
class HomeController extends Controller
{

  public function index()
  {
    $post = new PostModel();
    $posts = $post->all();

    $this->views('/home', ['posts' => $posts]);
  }
  public function store()
  {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $posts = new PostModel();
    $data = [
      'username' => $username,
      'email' => $email,
      'password' => $password,
    ];
    dd($data);
    $posts->create($data);
  }

  public function create()
  {
    $this->views('/create');
  }
}
