<?php

namespace blog\controllers\posts;

use blog\controllers\Controller;
use blog\model\PostModel;
use blog\services\auth\Auth;
use blog\services\Html\InputUtilized;
use blog\services\Message;
use blog\services\ResponseCode;

class PostController extends Controller
{
  use ResponseCode;
  protected $message;
  protected $auth;
  public function __construct()
  {
    $this->message = new Message();
    $this->auth = new Auth();
  }
  public function index()
  {
    $this->views('/posts/index');
  }
  public function show($id)
  {
    $showPost = new PostModel();
    $post = $showPost->find(['id' => $id]);
    $this->views('/posts/show', ['post' => $post]);
  }
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $createPost = new PostModel();
      $title = $_POST['title'];
      $content = $_POST['content'];

      $data = [
        'user_id' => $this->auth->userId(),
        'title' => $title,
        'content' => $content
      ];
      $create = $createPost->create($data);
      if ($create) {
        $this->message->messageWithRoute('/', 'Post created successfully', 'success');
      }
    }
  }
}
