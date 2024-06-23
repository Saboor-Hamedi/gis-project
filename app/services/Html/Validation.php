<?php

namespace blog\services\Html;

class Validation
{
  public function email($email)
  {
    if (empty($email)) {
      return 'email is required';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'email is not valid';
    }
    return null; // no error
  }
  public function password($input, $rules)
  {
    foreach ($rules as $rule) {
      $rule_name = key($rule);
      $message = current($rule);
      switch ($rule_name) {
        case 'required':
          if (empty($input)) {
            return $message;
          }
          break;
        case 'min':
          $min_length = $rule['min'];
          if (strlen($input) < $min_length) {
            return $message;
          }
          break;
        default:
          break;
      }
    }
    return null; // no validation errors
  }
}
