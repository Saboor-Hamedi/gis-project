# Using the views Function in Closures
## Prerequisites
Ensure you have set up your project environment correctly:

##### PHP Version: Ensure PHP 7 or higher is installed.
Directory Structure: Have a clear understanding of your application's directory structure, especially where helpers.php and your main application files (`bootstrap.php`, `index.php`) are located.
Setting Up `closures.php`
In order to use the views function within closures, you need to include it in your `closures.php` file. If you haven't already, define the views function in `closures.php` as shown below:
```php
// `helpers.php`

// Check if the function 'views' does not already exist
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


```
Ensure `closures.php` is required at the beginning of your bootstrap process (bootstrap.php or similar) to make the views function and other helper functions available throughout your application.

Using the views Function in Closures
You can use the views function inside closure functions to render views dynamically. Here's how you can set it up:
```php
// Example of using the views function within a closure
$router->get('/test', function() {
    // Render the '/test' view passing in an array of data
    return views('/test', ['errors' => []]);
});

```
#### Explanation: In the example above:
/test is the path to the view file relative to your views directory.
['errors' => []] is an optional array of data that can be passed to the view to dynamically populate content.
## Notes
Controller Dependency: The views function internally uses a Controller class to render views. Ensure the namespace (\blog\controllers\Controller) matches your actual namespace where Controller is defined.

Error Handling: If you encounter issues where the views function is not recognized, ensure helpers.php is properly included in your bootstrap process.

