<?php

namespace blog\controllers\dashboard;

use blog\controllers\Controller;
use blog\model\LoginModel;
use blog\model\PostModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;
use blog\services\Html\InputUtilized;
use blog\services\Html\Validation;
use blog\services\Message;
use blog\services\ResponseCode;

class AdminController extends Controller
{
  protected $middleware;
  protected $auth;
  protected $postModel;
  protected $userPost;
  protected $validate;
  protected $message;
  use ResponseCode;

  public function __construct()
  {
    $this->postModel = new PostModel();
    $this->userPost = new LoginModel();
    $this->middleware = new Middleware();
    $this->validate = new Validation();
    $this->message = new Message();
    $this->middleware->requireLoggedIn();
    $this->middleware->requireRoles([0]); // Only admins (role 0) can access
    $this->auth = new Auth();
  }
  public function index()
  {
    $id = $this->auth->userId();
    $users = $this->userPost->find(['id' => $id]);
    $posts = $this->postModel->where(['user_id' => $id]);
    $this->views('/dashboard/admin', ['users' => $users, 'posts' => $posts]);;
  }
  public function show($id)
  {
    $id = InputUtilized::sanitizeInput($id, 'float');
    $post = $this->postModel->find(['id' => $id]);
    // check if post id not found 
    if (!$post) {
      return $this->sendResponse(self::NOT_FOUND, 'Post not found');
    }
    // check if current post belongs to the current user_id 
    if (!$this->auth->isAuthorized($post[0]['user_id'])) {
      return $this->sendResponse(self::FORBIDDEN, 'Unauthorizedt post');
    }
    $this->views('/dashboard/show', ['post' => $post]);
  }
  public function update($id)
  {
    $id = InputUtilized::sanitizeInput($id, 'float');
    $post = $this->postModel->find(['id' => $id]);

    if (!$post) {
      return $this->sendResponse(self::NOT_FOUND, 'Post not found');
    }
    // Check if post belongs to the current user
    if (!$this->auth->isAuthorized($post[0]['user_id'])) {
      return $this->sendResponse(self::FORBIDDEN, 'You are not authorized to edit');
    }
    $this->views('/dashboard/update', ['post' => $post]);
  }
  public function edit()
  {

    $errors = $this->postModel->input($this->validate);
    if (!empty($errors)) {
      $this->views('/dashboard/update', ['errors' => $errors]);
      return;
    }
    $title = InputUtilized::sanitizeInput($_POST['title'], 'string');
    $content = InputUtilized::sanitizeInput($_POST['content'], 'string');
    $id = InputUtilized::sanitizeInput($_POST['id'], 'int');

    $data = [
      'title' => $title,
      'content' => $content
    ];
    $condition = [
      'id' => $id
    ];


    $results = $this->postModel->update($data, $condition);
    if (!$results) {
      return false;
    }
    $this->message->messageWithRoute('/dashboard/admin', 'Post created successfully', 'success');
  }
  public function create()
  {
    $this->views('/dashboard/create');
  }
  public function store()
  {
    // --------- validate inputs, it somes from PostModel
    $errors = $this->postModel->input($this->validate);

    if (!empty($errors)) {
      // Handle errors (e.g., redirect back with errors or display error messages)
      $this->views('/dasboard/create', ['errors' => $errors]);
      return;
    }
    // ---------- Sanitize the inputs
    $title = InputUtilized::sanitizeInput($_POST['title'], 'string');
    $content = InputUtilized::sanitizeInput($_POST['content'], 'string');
    $user_id = InputUtilized::sanitizeInput($this->auth->userId(), 'int');

    $data = [
      'user_id' => $user_id,
      'title' => $title,
      'content' => $content
    ];
    $create = $this->postModel->create($data);
    if (!$create) {
      return false;
    }
    $this->message->messageWithRoute('/dashboard/admin', 'Post created successfully', 'success');
  }
  public function destroy($id)
  {
    // Check if post belongs to the current user
    $id = InputUtilized::sanitizeInput($id, 'float');
    $post = $this->postModel->find(['id' => $id]);
    if (!$this->auth->isAuthorized($post[0]['user_id'])) {
      return $this->sendResponse(self::FORBIDDEN, 'You are not authorized to edit');
    }
    // Delete post
    $delete = $this->postModel->delete(['id' => $id]);
    if ($delete) {
      $this->message->messageWithRoute('/dashboard/admin', 'Post deleted successfully', 'success');
    }
  }
}
