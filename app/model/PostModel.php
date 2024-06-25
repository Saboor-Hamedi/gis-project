<?php
declare(strict_types=1);
namespace blog\model;

use blog\model\src\Model;

class PostModel extends Model
{
  protected $table = 'posts';
  protected $fillable = ['id','title', 'content' ,'user_id', 'created_at'];

  public function __construct()
  {
      parent::__construct($this->table);
  }
}
