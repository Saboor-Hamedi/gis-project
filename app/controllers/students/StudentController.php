<?php

namespace blog\controllers\students;


use blog\controllers\Controller;
use blog\model\LoginModel;
use blog\model\PostModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;
use blog\services\Html\InputUtilized;
use blog\services\Html\Validation;
use blog\services\Message;
use blog\services\ResponseCode;


class StudentController extends Controller
{


  protected $message;
  protected $middleware;
  protected $auth;
  protected $studentModel;
  protected $postModel;
  protected $validate;
  use ResponseCode;
  public function __construct()
  {
    $this->auth = new Auth();
    $this->middleware = new Middleware();
    $this->studentModel = new LoginModel();
    $this->postModel = new PostModel();
    $this->message = new Message();
    $this->validate = new Validation();

    $this->middleware->requireLoggedIn();
    $this->middleware->requireRoles([1]); // Only student (role 0) can access
  }
  public function index()
  {
    $id = $this->auth->userId();
    $users = $this->studentModel->find(['id' => $id]);
    $id = ['user_id' => $id];
    $limit = 10;
    $offset = 0;

    $posts = $this->postModel->where($id, $limit, $offset, 'created_at', 'DESC');
    $this->views('/students/index', ['users' => $users, 'posts' => $posts]);
  }
  public function show($id)
  {
    $id = InputUtilized::sanitizeInput($id, 'flot');
    $post = $this->postModel->find(['id' => $id]);
    // check if post id not found
    if (!$post) {
      return $this->sendResponse(self::NOT_FOUND, 'Post not found');
    }

    $this->views('/students/show', ['post' => $post]);
  }
  public function update($id)
  {
    $id = InputUtilized::sanitizeInput($id, 'flot');
    $post = $this->postModel->find(['id' => $id]);
    // check if post id not found
    if (!$post) {
      return $this->sendResponse(self::NOT_FOUND, 'Post not found');
    }
    // check if current post belongs to the current user_id 
    if (!$this->auth->isAuthorized($post[0]['user_id'])) {
      return $this->sendResponse(self::NOT_FOUND, 'Unauthorized post');
    }
    $post = $this->postModel->find(['id' => $id]);
    $this->views('/students/update', ['post' => $post]);
  }
  public function edit()
  {

    $errors = $this->postModel->input($this->validate);
    if (!empty($errors)) {
      $this->views('/students/update', ['errors' => $errors]);
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
    $this->message->messageWithRoute('/students/index', 'Post created successfully', 'success');
  }
  public function create()
  {
    $this->views('/students/create');
  }
  public function store()
  {
    // --------- validate inputs, it somes from PostModel
    $errors = $this->postModel->input($this->validate);
    if (!empty($errors)) {
      // Handle errors (e.g., redirect back with errors or display error messages)
      $this->views('/students/create', ['errors' => $errors]);
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
    $this->message->messageWithRoute('/students/index', 'Post created successfully', 'success');
  }
  public function destroy($id)
  {
    $id = InputUtilized::sanitizeInput($id, 'int');
    $post = $this->postModel->find(['id' => $id]);
    // check if current post belongs to the current user_id 
    if (!$this->auth->isAuthorized($post[0]['user_id'])) {
      return $this->sendResponse(self::NOT_FOUND, 'Unauthorized post');
    }
    $delete = $this->postModel->delete(['id' => $id]);
    if ($delete) {
      $this->message->messageWithRoute('/students/index', 'Post deleted successfully', 'success');
    }
  }
}
