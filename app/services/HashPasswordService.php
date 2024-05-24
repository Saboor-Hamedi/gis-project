<?php 
declare(strict_types=1);
namespace blog\services;
class HashPasswordService {
  public final function encryptPassword($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }
  public function verifyPassword($password, $hash){
    return password_verify($password, $hash);
  }
}
