<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Not Found</title>
  <style>
    /* Add your custom styles for the 404 page here */
    body {
      font-family: sans-serif;
      text-align: center;
    }

    .message {
      font-size: 2em;
      margin-top: 50px;
      /* Adjusted margin-top for better alignment */
    }

    .error-img {
      width: 200px;
      /* Adjusted image width */
      margin-bottom: 20px;
      /* Added margin-bottom for spacing */
    }
  </style>
</head>

<body>
  <?php
  $message = isset($message) ? (string) $message : 'The page you requested could not be found.';
  ?>
  <img src="<?php assets('images/logo.png') ?>" class="error-img">
  <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
  <a href="/">Go to Home Page</a>
</body>

</html>