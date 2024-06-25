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
    $result = $this->db->single($sql);
    $filter = $this->filterData($result, $this->fillable);
    if (is_array($filter) || is_object($filter)) {
      return [$filter];
    }
    return [];
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
    $filter = $this->filterData($result, $this->fillable);

    // Ensure the filtered result is always returned as an array
    if (is_array($filter) || is_object($filter)) {
      return [$filter];
    }

    return [];
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
