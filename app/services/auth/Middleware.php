<?php

namespace blog\services\auth;

use blog\services\Message;
use blog\services\ResponseCode;
use blog\services\Session;

class Middleware
{
  protected $session;
  protected $auth;
  use ResponseCode;
  protected $message ;
  public function __construct()
  {
    $this->session = new Session();
    $this->auth = new Auth();
    $this->message = new Message();
  }

  // check if user is loggedin
  public function requireLoggedIn()
  {
    if (!$this->session->has('user_id')) {
      $this->redirect('/login/login');
      
    }
  }

 // do not allow user go back
  public function preventBackWhenLoggedIn()
  {
    if ($this->session->has('user_id')) {
      $this->redirect('/dashboard/admin');
    }
  }
  // roles 
  // public function requireRoles(array $roles)
  // {
  //   if (!$this->auth->hasRoles($roles)) {
  //     $this->session->destroy();
  //     $this->redirect('/login/login');
  //   }
  // }

   public function requireRoles(array $roles)
    {
        $userRole = $this->session->get('roles');
        if (!in_array($userRole, $roles)) {
            $this->sendResponse(self::FORBIDDEN, 'Unauthorized!'); // or any forbidden page
        }
    }

  public function redirect(string $url, int $statusCode = 302): void
  {
    header('Location: ' . $url, true, $statusCode);
    exit();
  }
}
