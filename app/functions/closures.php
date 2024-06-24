<?php
use blog\controllers\Controller;

// closure function 
// $router->get('/test', function() {
//     return view('/test');
// });
if (!function_exists('views')) {
    function views(string $view, array $data = [])
    {
        $controller = new Controller();
        ob_start();
        $controller->views($view, $data);
        return ob_get_clean();
    }
}


