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
  public function string($input, $rules)
  {
    foreach ($rules as $rule) {
      $rule_name = $rule[0];
      $message = isset($rule[1]) ? $rule[1] : 'Invalid input';

      switch ($rule_name) {
        case 'required':
          if (is_null($input) || trim((string) $input) === '') {
            return $message;
          }
          break;
        case 'min':
          $min = isset($rule[2]) ? $rule[2] : 0;
          if (is_null($input) || strlen((string) $input) < $min) {
            return $message;
          }
          break;
        case 'max':
          $max = isset($rule[2]) ? $rule[2] : PHP_INT_MAX;
          if (is_null($input) || strlen((string) $input) > $max) {
            return $message;
          }
          break;
      }
    }
    return '';
  }


}
