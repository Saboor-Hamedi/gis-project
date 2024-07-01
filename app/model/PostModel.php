<?php

declare(strict_types=1);

namespace blog\model;

use blog\model\src\Model;
use blog\services\ResponseCode;

class PostModel extends Model
{
  use ResponseCode;
  protected $table = 'posts';
  protected $fillable = ['id', 'user_id', 'title', 'content', 'created_at'];

  public function __construct()
  {
    parent::__construct($this->table);
  }
  public function singlePostWithUser($id)
  {
    $sql = "
        SELECT 
  users.username, 
  users.id, 
  posts.title, 
  posts.content, 
  posts.created_at 
FROM 
  users 
  INNER JOIN posts ON users.id = posts.user_id 
WHERE 
  posts.id = :id
    ";
    $results = $this->db->single($sql, [':id' => $id]);
    // if (!$results) {
    //   $this->sendResponse(self::NOT_FOUND, 'Post not found');
    // }
    return $results;
  }


  public function allWithUser(?int $limit = null, int $offset = 0, ?string $orderBy = null, string $orderDirection = 'ASC')
  {
    $columns = implode(', ', $this->fillable);
    $sql = "SELECT posts.*, users.username 
                FROM posts 
                JOIN users ON posts.user_id = users.id";

    if ($orderBy !== null) {
      $sql .= " ORDER BY {$orderBy} {$orderDirection}";
    }

    if ($limit !== null) {
      $sql .= " LIMIT {$limit} OFFSET {$offset}";
    }

    $results = $this->db->all($sql);
    return $results;
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
