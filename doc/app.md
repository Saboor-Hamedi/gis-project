
# App.php 

* Function Name: requestMethod<br>
    **Description:**
    - This function returns the HTTP request method used by the client. It first checks the value of $_SERVER['REQUEST_METHOD']. 
    - If this is not set, it defaults to an empty string. 
    - If an override method is provided in the POST request parameter '_method', it will use that instead, converting it to uppercase.
    **Return Type:**
    . string
    . Example Usage:
    . $requestMethod = requestMethod();
* Function Name: getRequestUri<br>
    **Description:**
    - This function retrieves the requested URI (Uniform Resource Identifier) from the current HTTP request. 
    - It parses the value of $_SERVER['REQUEST_URI'] and extracts the path component using the PHP_URL_PATH option of the parse_url function. 
    - If the REQUEST_URI is not set or empty, it returns an empty string.
    **Return Type:**
    . string
    . Example Usage:
    . $requestUri = getRequestUri();


  
  **Function: url(string $routeName): string**

This function generates a URL based on a provided route name within a framework (likely Laravel).

**Parameters:**

- `$routeName` (string): The name assigned to the desired route in your framework's routing configuration.

**Return Value:**

- `string`: The generated URL corresponding to the specified route name.

**Functionality:**

1. **App Instance Creation:**
   - The function creates a new instance of the `App` class. This class is likely part of your framework and is responsible for handling routing mechanisms.

2. **Route Retrieval:**
   - The `route` method of the `App` instance is called, passing the `$routeName` as an argument. This method presumably retrieves information about the route with that name from the framework's routing configuration.

3. **URL Generation (Implicit):**
   - While not explicitly shown in the provided code, the `route` method likely returns the generated URL based on the route definition. The framework typically handles URL construction based on route patterns, parameters, and domain configuration.

4. **Echo and Return:**
   - The function includes an `echo` statement, which would typically be used for debugging or logging purposes within the code itself. It wouldn't be part of the actual returned value.
   - The function also returns the generated URL, which can be used by the calling code to construct links or redirect users.


```php
<?php

// Assuming routes are defined in routes/web.php
Route::get('/products', function () {
    // ... Controller logic for the 'products' route
})->name('productList');

$url = url('productList'); // Call the function with the route name
echo $url; // This would likely print "/products"
``` 

### Example 

```html
<form  action="<?php url('/post/delete/' . $post['id']); ?>"  method="POST" style="display:inline;">
  <?php CSRF::generate(); ?>
  <input type="hidden" name="_method" value="DELETE">
  <button type="submit" class="btn btn-danger">Delete</button>
</form>
```
