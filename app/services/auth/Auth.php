<?php

namespace blog\services\auth;

use blog\services\Session;



class Auth
{
  protected $session;
  public function __construct()
  {
    $this->session = new Session();
  }
  public function userId()
  {
    return $this->session->get('user_id');
  }
  
  public function check()
  {
    return $this->session->has('user_id');
  }
  public function isAuthorized($user_id){
    $currentUserId = $this->userId();
     return $currentUserId === $user_id;
  }
}
