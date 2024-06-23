<?php

declare(strict_types=1);

namespace blog\model\src;

use blog\database\Database;

class Model
{
  protected $db;
  protected $table;
  protected $fillable = [];
  protected $guarded = [
    '*'
  ];
  public function __construct($table)
  {
    $this->db = new Database();
    $this->table = $table;
  }
  // public function all()
  // {
  //   $sql = "SELECT * FROM {$this->table}";
  //   return $this->db->all($sql);
  // }

  public function all(?int $limit = null, int $offset = 0, ?string $orderBy = null, string $orderDirection = 'ASC')
  {
    // Get fillable columns
    $columns = $this->fillable;

    // Format columns
    $columns = implode(', ', $columns);

    // Build the SQL query
    $sql = "SELECT {$columns} FROM {$this->table}";

    // Add ORDER BY clause
    if ($orderBy !== null) {
      $sql .= " ORDER BY {$orderBy} {$orderDirection}";
    }

    // Add LIMIT and OFFSET clauses
    if ($limit !== null) {
      $sql .= " LIMIT {$limit} OFFSET {$offset}";
    }

    // Execute the query and return the result
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
    return $this->db->find($this->table, $condition);
  }
  public function delete($condition)
  {
    return $this->db->delete($this->table, $condition);
  }
  public function update($data, $condition)
  {
    return $this->db->update($this->table, $data, $condition);
  }
 
  public function findBy($column, $value)
  {
    $condition = [$column => $value];
    $cond =  $this->find($condition);
    return $cond;
  }
  protected function filterData($data, $allowedAttributes)
  {

    // if guarded,  no attribute can be allowed 
    if (in_array('*', $allowedAttributes)) {
      return [];
    }
    // filter the data to include only allowed 
    return array_intersect_key($data, array_flip($allowedAttributes));
  }
}
