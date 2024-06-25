<?php 
namespace blog\model\student;

use blog\model\src\Model;

class StudentsModel extends Model{

    protected $table = 'users';
    protected $fillable = ['username', 'email','created_at'];
    public function __construct(){
        parent::__construct($this->table);
    }

}