<?php

declare(strict_types=1);

namespace blog\model\src;

use blog\database\Database;

class Model
{
  protected $db;
  protected $table;
  protected $fillable = [];
  protected $guarded = ['*'];
  public function __construct($table)
  {
    $this->db = new Database();
    $this->table = $table;
  }

  public function all(?int $limit = null, int $offset = 0, ?string $orderBy = null, string $orderDirection = 'ASC')
  {
    $columns = implode(', ', $this->fillable);
    $sql = "SELECT {$columns} FROM {$this->table}";

    if ($orderBy !== null) {
      $sql .= " ORDER BY {$orderBy} {$orderDirection}";
    }

    if ($limit !== null) {
      $sql .= " LIMIT {$limit} OFFSET {$offset}";
    }

    return $this->db->all($sql);
  }

  public function single()
  {
    $sql = "SELECT * FROM {$this->table} LIMIT 1";
    return $this->db->single($sql);
  }
  public function create($data)
  {
    // Filter the data to include only fillable attributes
    $fillableData = $this->filterData($data, $this->fillable);
    return $this->db->insert($this->table, $fillableData);
  }
  public function find($condition)
  {
    $result = $this->db->find($this->table, $condition);
    if ($result) {
      $filter = $this->filterData($result, $this->fillable);
      // Ensure the result is processed as needed, possibly filtering or manipulating it
      return [$filter];
    }
    return null; // or an empty array/object as appropriate
  }

  public function where(array $conditions, ?int $limit = null, int $offset = 0, ?string $orderBy = null, string $orderDirection = 'ASC')
  {
    $columns = implode(', ', $this->fillable);
    $whereClause = [];
    $params = [];

    foreach ($conditions as $key => $value) {
      if (is_array($value)) {
        $inValues = implode(',', array_fill(0, count($value), '?'));
        $whereClause[] = "$key IN ($inValues)";
        $params = array_merge($params, $value);
      } else {
        $whereClause[] = "$key = :$key";
        $params[":$key"] = $value;
      }
    }

    $whereClause = implode(' AND ', $whereClause);
    $sql = "SELECT {$columns} FROM {$this->table} WHERE {$whereClause}";

    if ($orderBy !== null) {
      $sql .= " ORDER BY {$orderBy} {$orderDirection}";
    }

    if ($limit !== null) {
      $sql .= " LIMIT {$limit} OFFSET {$offset}";
    }

    // Debugging output
    //var_dump($sql, $params);

    return $this->db->all($sql, $params);
  }



  public function delete($condition)
  {
    return $this->db->delete($this->table, $condition);
  }
  public function update($data, $condition)
  {
    $fillableData = $this->filterData($data, $this->fillable);
    return $this->db->update($this->table, $fillableData, $condition);
  }
  public function login($condition)
  {
    return $this->db->find($this->table, $condition);
  }
  public function findBy($column, $value)
  {
    $condition = [$column => $value];
    $cond = $this->login($condition);
    return $cond;
  }
  protected function filterData($data, $allowedAttributes)
  {
    if (in_array('*', $allowedAttributes)) {
      return [];
    }
    return array_intersect_key($data, array_flip($allowedAttributes));
  }
}
