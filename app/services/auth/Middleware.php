<?php

namespace blog\services\auth;

use blog\services\Session;

class Middleware
{
  protected $session;
  public function __construct()
  {
    $this->session = new Session();
  }

  public function requireLoggedIn()
  {
    if (!$this->session->has('user_id')) {
      $this->redirect('/login/login');;
    }
  }

  public function preventBackWhenLoggedIn()
  {
    if ($this->session->has('user_id')) {
      $this->redirect('/dashboard/admin');
    }
  }

  public function redirect(string $url, int $statusCode = 302): void
  {
    header('Location: ' . $url, true, $statusCode);
    exit();
  }
}
