# Authentication class

1. user_id <br >
   . **Purpose:** Retrieves the current user's ID from the session.
   . **Description:** This function returns the user ID stored in the session. It is used to identify the currently logged-in user.

```php
public function userId()
{
    return $this->session->get('user_id');
}
```

2. check <bre>
   . **Purpose:** Checks if a user is logged in
   . **Description:** This function checks if the session contains a user ID, indicating that a user is currently logged in. It returns `true` if a user is logged in, and `false` otherwise

```php
public function check()
{
    return $this->session->has('user_id');
}

```

1. isAuthorized <br>
   . **Purpose:** Checks if the current user is authorized to perform an action.
   .**Description:** This function compares the current user's ID (retrieved from the session) with a given user ID. It returns true if the current user ID matches the given user ID, indicating that the user is authorized to perform the action.

```php
public function isAuthorized($user_id)
{
    $currentUserId = $this->userId();
    return $currentUserId === $user_id;
}
```

### Usage Example

```php
public function destroy($id)
  {

    $postModel = new PostModel(); // initialize the model
    $user_id = $postModel->find(['id' => $id]); // find id of post
    if (!$this->auth->check()) { // check if the user is logged in
      $this->sendResponse(401);
    }

    if(!$user_id){
      $this->sendResponse(404);
    }
    // you can do this instead of isAuthorized.
    $currentUserId = $this->auth->userId();
    if ($post['user_id'] !== $currentUserId) {
        $this->sendResponse(403); // Send a 403 Forbidden response if not authorized
    }
    // the code above will work the same as isAuthorized
    if (!$this->auth->isAuthorized($user_id['user_id'])) {
      $this->sendResponse(403);
    }
    // Perform the delete operation
    $postModel->delete(['id' => $id]);
    $this->message->messageWithRoute('/', 'Post deleted successfully', 'success');
  }
```
