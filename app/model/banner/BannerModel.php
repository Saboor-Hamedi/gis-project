<?php
namespace blog\model\banner;
use blog\model\src\Model;

class BannerModel extends Model
{
  protected $table = 'banner';
  protected $fillable = ['title', 'content', 'created_at'];

  public function __construct()
  {
      parent::__construct($this->table);
  }
  public function getAllBanners(){
    return $this->single();
  }
}
