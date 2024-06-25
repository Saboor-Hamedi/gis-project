<?php
namespace blog\controllers\students;


use blog\controllers\Controller;
use blog\model\LoginModel;
use blog\model\PostModel;
use blog\model\student\StudentsModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;
use blog\services\Message;


class StudentController extends Controller
{

 
    protected $message;
    protected $middleware;
    protected $auth;
    protected $studentModel;
    protected $postModel;
    public function __construct()
    {
        $this->studentModel = new LoginModel();
        
        $this->middleware = new Middleware();
        $this->middleware->requireLoggedIn();
        $this->auth = new Auth();
        $this->message = new Message();
        $this->postModel = new PostModel();
        $this->middleware->requireRoles([1]); // Only student (role 0) can access
    }
    public function index()
    {
        $id = $this->auth->userId();
        $users = $this->studentModel->find(['id' =>$id]);
        $posts = $this->postModel->where(['user_id' =>$id]);
        
        $this->views('/students/index', ['users' => $users, 'posts' => $posts]);
    }
    public function show()
    {
        $this->views('/students/show');
    }
    public function create(){
        $this->views('/students/create');
    }
    public function store(){
       
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
        $this->message->messageWithRoute('/students/index', 'Post created successfully', 'success');
      }
    }
}