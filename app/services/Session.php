<?php

declare(strict_types=1);

namespace blog\services;

class Session
{
  public function __construct()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
      // dd("Session started: " . session_id());
    }
  }
  public function get(string $key)
  {
    $value = $_SESSION[$key] ?? null;
    return $value;
  }
  public function set(string $key, $value): void
  {
    $_SESSION[$key] = $value;
  }
  public function has(string $key): bool
  {
    $exists =  isset($_SESSION[$key]);
    return $exists;
  }
  public function remove(string $key): void{
    unset($_SESSION[$key]);
  }
  public function destroy(): void
  {
    session_destroy();
  }



  public function clear(): void
  {
    session_unset();
  }
}
