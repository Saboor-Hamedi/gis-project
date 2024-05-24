<?php
declare(strict_types=1);
namespace blog\model;

use blog\model\src\Model;

class PostModel extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password'];

    public function __construct()
    {
        parent::__construct($this->table);
    }
}
