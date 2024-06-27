# A self note
- Before you read this note, here is a quick note:<br>
 **_NOTE:_** This is a personal note, I am sure it's note going to perfect by no mean, 
 
 ### I hope that you understand it.   
`install str::limit composer require illuminate/support`
<hr />

The compileRoute method is designed to convert route definitions like 
> /user/{id} into regex patterns like #^/user/(?P<id>[^/]+)$#. 
Here’s a step-by-step breakdown of the method:

also install install `composer require nesbot/carbon`
show the time like facebook: `<small class="mb-2"><?php echo Carbon::parse($post['created_at'])->diffForHumans(); ?></small>`

### errors
`errors` is a default variable for showing the inputs and other errors on the views, `errors` comes from -[x] `Controller.php`, if you want to `errors` to something else you must change it from `Controller.php`. 

also, you must check first variable then validate it
```php 
$title = isset($_POST['title']) ? $_POST['title'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
```