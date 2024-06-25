<?php
namespace blog\controllers\dashboard;

use blog\controllers\Controller;
use blog\services\auth\Auth;
use blog\services\auth\Middleware;

class AdminController extends Controller
{
  protected $middleware;
  protected $auth;
  public function __construct()
  {
    $this->middleware = new Middleware();
    $this->middleware->requireLoggedIn();
    $this->middleware->requireRoles([0]); // Only admins (role 0) can access
  }
  public function index()
  {
    $this->views('/dashboard/admin');
  }
  public function show()
  {
    $this->views('/dashboard/show');
  }
}
