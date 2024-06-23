<?php

declare(strict_types=1);

namespace blog\database;

use blog\exceptions\ConfigException;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
  protected $pdo;
  protected $error;
  protected $stmt;
  protected $dsn;
  protected $options;

  public function __construct()
  {
    $env = Dotenv::createImmutable(__DIR__ . '/../../');
    $env->load();
    $this->dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'];
    $this->options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
      $this->pdo = new PDO($this->dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $this->options);
    } catch (PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
    }
  }

  public function executeStatement($statement = null, $data = [])
  {
    try {
      $this->stmt = $this->pdo->prepare($statement);
      $this->stmt->execute($data);
      return $this->stmt;
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      error_log("Database query error: " . $e->getMessage());
      return null;
    }
  }

  public function all($statement = null, $data = [])
  {
    $stmt = $this->executeStatement($statement, $data);
    if ($stmt) {
      $results = $stmt->fetchAll();
      array_walk_recursive($results, function (&$item) {
        if (is_null($item)) {
          $item = ''; // or any default value you prefer
        }
      });
      return $results;
    }
    return [];
  }

  public function single($statement = null, $data = [])
  {
    $stmt = $this->executeStatement($statement, $data);
    if ($stmt) {
      $result = $stmt->fetch();
      array_walk_recursive($result, function (&$item) {
        if (is_null($item)) {
          $item = ''; // or any default value you prefer
        }
      });
      return $result;
    }
    return null;
  }

  public function find($table = null, $condition = [])
  {
    $whereClause = [];
    $params = [];
    foreach ($condition as $key => $value) {
      $whereClause[] = "$key = :$key";
      $params[":$key"] = $value;
    }
    $whereClause = implode(' AND ', $whereClause);

    $statement = "SELECT * FROM $table WHERE $whereClause LIMIT 1";
    $stmt = $this->executeStatement($statement, $params);
    if ($stmt) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC); // Ensure associative array fetch
      if ($result) {
        array_walk_recursive($result, function (&$item) {
          if (is_null($item)) {
            $item = ''; // or any default value you prefer
          }
        });
        return $result;
      }
    }
    return null; // Ensure the method returns null if no result is found
  }

  public function insert($table, $data)
  {
    $columns  = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_map(function ($key) {
      return ":" . $key;
    }, array_keys($data)));

    $statement = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    return $this->executeStatement($statement, $data);
  }

  public function update($table, $data, $condition)
  {
    $set = [];
    foreach ($data as $key => $value) {
      $set[] = "$key = :$key";
    }
    $setString = implode(', ', $set);

    $whereString = '';
    $params = $data;
    if (is_array($condition) || is_object($condition)) {
      $where = [];
      foreach ($condition as $key => $value) {
        $where[] = "$key = :$key";
        $params[":$key"] = $value; // Add condition parameters to $params
      }
      $whereString = "WHERE " . implode(' AND ', $where);
    }
    $statement = "UPDATE $table SET $setString $whereString";
    return $this->executeStatement($statement, $params);
  }

  public function delete($table, $condition)
  {
    $whereString = '';
    $params = [];
    if (is_array($condition) || is_object($condition)) {
      $where = [];
      foreach ($condition as $key => $value) {
        $where[] = "$key = :$key";
        $params[":$key"] = $value; // Add condition parameters to $params
      }
      $whereString = "WHERE " . implode(' AND ', $where);
      $statement = "DELETE FROM $table $whereString";
      return $this->executeStatement($statement, $params);
    }
  }

  public function close()
  {
    $this->pdo = null;
  }
}
