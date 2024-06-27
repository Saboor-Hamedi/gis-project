<?php path('layout/frontPage'); 
use blog\services\Message;?>
<?php $msg = new Message() ?>

<div class="login-card">
<?php $msg->displayMessage();?>
  <h2>Login</h2>
  <form action="<?php url('/login/login'); ?>" method="POST">
    <div class="input-group">
      <label for="email">Email</label>
      <input type="text" id="email" name="email">
      <?php error($errors, 'email') ?>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <?php error($errors, 'password');?>
    </div>
    <button type="submit" class="login-btn">Login</button>
  </form>
</div>
<?php path('layout/footer'); ?>
<!-- <script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script> -->
