<?php
namespace blog\controllers\students;


use blog\controllers\Controller;
use blog\model\PostModel;
use blog\model\student\StudentsModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;


class StudentController extends Controller
{

    protected $middleware;
    protected $auth;
    protected $studentModel;
    public function __construct()
    {
        $this->studentModel = new StudentsModel();
        $this->middleware = new Middleware();
        $this->middleware->requireLoggedIn();
        $this->auth = new Auth();
        $this->middleware->requireRoles([1]); // Only student (role 0) can access
    }
    public function index()
    {
        $id = $this->auth->userId();
        $posts = $this->studentModel->find(['id' =>$id]);
        

        $this->views('/students/index', ['posts' => $posts]);
    }
    public function show()
    {
        $this->views('/students/show');
    }
}