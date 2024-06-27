<?php
namespace blog\controllers\dashboard;

use blog\controllers\Controller;
use blog\model\LoginModel;
use blog\model\PostModel;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;

class AdminController extends Controller
{
  protected $middleware;
  protected $auth;
  protected $adminPost;
  protected $userPost;

  public function __construct()
  {
    $this->adminPost = new PostModel();
    $this->userPost = new LoginModel();
    $this->middleware = new Middleware();
    $this->middleware->requireLoggedIn();
    $this->middleware->requireRoles([0]); // Only admins (role 0) can access
    $this->auth = new Auth();
  }
  public function index()
  {

    $id = $this->auth->userId();
    $users = $this->userPost->find(['id' => $id]);
    $posts = $this->adminPost->where(['user_id' => $id]);

    $this->views('/dashboard/admin', ['users' => $users, 'posts' => $posts]);
    ;
  }
  public function show()
  {
    $this->views('/dashboard/show');
  }
}
