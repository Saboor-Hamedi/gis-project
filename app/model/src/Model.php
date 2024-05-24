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
  public function all()
  {
    $sql = "SELECT * FROM {$this->table}";
    return $this->db->all($sql);
  }
  public function create($data)
  {
    // Filter the data to include only fillable attributes
    $fillableData = $this->filterData($data, $this->fillable);
    // insert
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
