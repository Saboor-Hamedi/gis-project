<?php
namespace blog\model;
use blog\model\src\Model;
use blog\services\Html\Validation;

class LoginModel extends Model{
  protected $table = 'users';
  protected $fillable = ['username', 'email', 'created_at', 'roles'];
  public function __construct()
  {
    parent::__construct($this->table);
  }
  // validate inputs
  public function input($valid){
    $errors = [];
    $errors['email'] = $valid->email($_POST['email']);
    $password = [
      ['required' => 'password required'],
    ];
    $errors['password'] = $valid->password($_POST['password'], $password);
    return array_filter($errors);
  }
}
