<?php 
declare(strict_types=1);

namespace blog\exceptions;

use Exception;

class ConfigException extends Exception{
  const SQL_SYNTAX_ERROR = 1;
  const DB_CONNECTION_ERROR = 2;
  
}
