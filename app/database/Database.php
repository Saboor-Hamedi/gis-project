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
  protected $dns;
  protected $options;
  public function __construct()
  {
    $env = Dotenv::createImmutable(__DIR__ . '/../../');
    $env->load();
    $this->dns = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_DATABASE'];
    $this->options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
      $this->pdo = new PDO($this->dns, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $this->options);
    } catch (ConfigException $e) {
      switch ($e->getCode()) {
        case ConfigException::DB_CONNECTION_ERROR:
          echo "Connection error\n";
          break;
        case ConfigException::SQL_SYNTAX_ERROR:
          echo "SQL error\n";
          break;
      }
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
    }
  }
  public function all($statement = null, $data = [])
  {
    try {
      $this->stmt = $this->executeStatement($statement, $data);
      $results = $this->stmt->fetchAll();
      // Transform NULL values in the results
      array_walk_recursive($results, function (&$item, $key) {
        if (is_null($item)) {
          $item = ''; // or any default value you prefer
        }
      });
      return $results;
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
    }
  }
  public function find($table = null, $id = null)
  {
    $statement = "SELECT * FROM $table WHERE id = :id LIMIT 1";
    $this->stmt = $this->executeStatement($statement, [':id' => $id]);
    $result = $this->stmt->fetch();
    // Transform null value in the result 
    if ($result) {
      array_walk_recursive($result, function (&$item, $key) {
        if (is_null($item)) {
          $item = '';
        }
      });
      return $result;
    }
  }
  public function insert($table, $data)
  {
    // extract column name 
    $columns  = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_map(function ($key) {
      return ":" . $key;
    }, array_keys($data)));

    // build insert statement
    $statement = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    return $this->executeStatement($statement, $data);
  }
  public function update($table, $data, $condition)
  {
    // Set builder
    $set = [];
    foreach ($data as $key => $value) {
      $set[] = "$key = :$key";
    }
    $setString = implode(', ', $set);

    // Where condition builder
    $whereString = '';
    $params = $data;
    if (is_array($condition) || is_object($condition)) {
      $where = [];
      foreach ($condition as $key => $value) {
        $where[] = "$key = :$key";
        $params[$key] = $value; // Add condition parameters to $params
      }
      $whereString = "WHERE " . implode(' AND ', $where);
    }
    $statement = "UPDATE $table SET $setString $whereString";
    return $this->executeStatement($statement, $params);
  }

  public function delete($table, $condition)
  {
    // where condition 
    $whereString = '';
    $params = [];
    if (is_array($condition)  || is_object($condition)) {
      $where = [];
      foreach ($condition as $key => $value) {
        $where[] = "$key = :$key";
        $params[$key] = $value; // Add condition parameters to $params
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
