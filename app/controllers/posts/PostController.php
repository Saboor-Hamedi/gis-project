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
  public function edit($id)
  {
    $postModel = new PostModel();
    $post = $postModel->find(['id'=>$id]);
    if(!$post){
      $this->sendResponse(404);
      die;
    }
    $this->views('posts/update', ['post' => $post]);
  }

  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $data = [
        'title' => inputUtilized::sanitizeInput($title, 'string'),
        'content' => inputUtilized::sanitizeInput($content, 'string'),
      ];
      $updatePost = new PostModel();
      $user_id = ['id' => inputUtilized::sanitizeInput($id, 'int')];
      $updatePost->update($data, $user_id);
      $this->message->messageWithRoute('/', 'Post updated successfully', 'success');
    }
  }

  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $createPost = new PostModel();
      $title = $_POST['title'];
      $content = $_POST['content'];
      
      $data = [
        'user_id' => $this->auth->userId() ,
        'title' => $title,
        'content' => $content
      ];
      $create = $createPost->create($data);
      if ($create) {
        $this->message->messageWithRoute('/', 'Post created successfully', 'success');
      }
    }
  }
  public function create()
  {
    
    $this->views('/posts/create');
  }
  public function destroy($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $deletePost = new PostModel();
      $delete = $deletePost->delete(['id' => $id]);
      if ($delete) {
        $this->message->messageWithRoute('/', 'Post deleted successfully', 'success');
      }
    }
  }
}
