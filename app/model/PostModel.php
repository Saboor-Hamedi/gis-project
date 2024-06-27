<?php
declare(strict_types=1);
namespace blog\model;

use blog\model\src\Model;

class PostModel extends Model
{
  protected $table = 'posts';
  protected $fillable = ['id', 'user_id', 'title', 'content', 'created_at'];

  public function __construct()
  {
    parent::__construct($this->table);
  }
  public function input($validate)
  {
    $errors = [];
    // Title validation
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $titleRules = [
      ['required', 'Title is required'],
      ['min', 'Title must be at least 3 characters', 3],
      ['max', 'Title must be less than 50 characters', 50]
    ];
    $errors['title'] = $validate->string($title, $titleRules);

    // Content validation
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $contentRules = [
      ['required', 'Content is required'],
      ['min', 'Content must be at least 10 characters', 10]
    ];
    $errors['content'] = $validate->string($content, $contentRules);

    // Filter out empty error messages
    $errors = array_filter($errors);

    return $errors;
  }


}
