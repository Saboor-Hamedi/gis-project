<?php
namespace blog\controllers\students;


use blog\controllers\Controller;
use blog\functions\CSRF;
use blog\model\LoginModel;
use blog\model\PostModel;
use blog\model\student\StudentsModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;
use blog\services\Html\InputUtilized;
use blog\services\Html\Validation;
use blog\services\Message;


class StudentController extends Controller
{


  protected $message;
  protected $middleware;
  protected $auth;
  protected $studentModel;
  protected $postModel;
  protected $validate;
  public function __construct()
  {
    $this->studentModel = new LoginModel();

    $this->middleware = new Middleware();
    $this->middleware->requireLoggedIn();
    $this->auth = new Auth();
    $this->message = new Message();
    $this->postModel = new PostModel();
    $this->middleware->requireRoles([1]); // Only student (role 0) can access
    $this->validate = new Validation();
  }
  public function index()
  {
    $id = $this->auth->userId();
    $users = $this->studentModel->find(['id' => $id]);
    $posts = $this->postModel->where(['user_id' => $id]);

    $this->views('/students/index', ['users' => $users, 'posts' => $posts]);
  }
  public function show()
  {
    $this->views('/students/show');
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
    $delete = $this->postModel->delete(['id' => $id]);
    if ($delete) {
      $this->message->messageWithRoute('/students/index', 'Post deleted successfully', 'success');

    }
  }
}