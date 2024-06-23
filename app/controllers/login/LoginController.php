<?php

namespace blog\controllers\login;

use blog\controllers\Controller;
use blog\model\LoginModel;
use blog\services\Html\InputUtilized;
use blog\services\Html\Validation;
use blog\services\Message;
use blog\services\ResponseCode;
use blog\services\Session;

class LoginController extends Controller
{

  use ResponseCode;
  protected LoginModel $loginModel;
  protected $session;
  protected $message;
  protected $validate;

  public function __construct()
  {
    $this->loginModel = new LoginModel();
    $this->validate = new Validation();
    $this->session = new Session();
    $this->message = new Message();
  }
  public function index()
  {
    $this->views('/login/login', ['errors' => []]);
  }
  public function login()
  {
    // -----------------sanitize----------------------
    $email = InputUtilized::sanitizeInput($_POST['email'], 'email') ?? '';
    $password = $_POST['password'] ?? '';
    $errors = $this->loginModel->input($this->validate);
    // -----------------checking----------------------
    if(!empty($errors)) {
      $this->views('/login/login', ['errors' => $errors]);
      return;
    }
    // ------------------login------------------------
    if ($this->authenticate($email, $password)) {
      $user = $this->loginModel->findBy('email', $email);
      $this->session->set('user_id', $user['id']); // store  user_id
      $this->redirect('/dashboard/admin');
    } else {
      $this->message->setMessage('Invalid email or password', 'danger');
      $this->views('/login/login', ['errors' => []]);
    }
  }
  public function authenticate(string $email, string $password): bool
  {
    $user = $this->loginModel->findBy('email', $email);
    if ($user && password_verify($password, $user['password'])) {
      return true;
    }
    return false;
  }
  public function logout()
  {
    $this->session->destroy();
    $this->redirect('/login/login');
  }
}
