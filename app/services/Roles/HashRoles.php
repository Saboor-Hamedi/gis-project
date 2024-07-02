<?php

namespace blog\services\Roles;

use blog\services\auth\Middleware;
use blog\services\ResponseCode;
use blog\services\Session;

trait HashRoles
{

    protected $middleware;
    protected $session;
    use ResponseCode;
    public function __construct()
    {
        $this->middleware = new Middleware();
        $this->session = new Session();
        $this->middleware->requireLoggedIn();
        $this->routeBasedOnRole();
    }
    protected function routeBasedOnRole()
    {
        $userRole = $this->session->get('roles');

        switch ($userRole) {
            case 0:
                $this->redirect('/dashboard/admin');
                break;
            case 1:
                $this->redirect('/students/index');
                break;
            case 2:
                $this->redirect('/teachers/index');
                break;
            default:
                $this->sendResponse(self::FORBIDDEN, 'Unauthorized'); // Forbidden page
                break;
        }
    }
}
