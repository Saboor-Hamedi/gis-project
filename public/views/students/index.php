<?php path('layout/main'); ?>
<div class="login-card" style="max-width: 80%">
    <h2>Student</h2>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <?php foreach($posts as $post): ?>
        <td><?php echo $post['username'] ?></td>
        <td><?php echo $post['email'] ?></td>
      <?php endforeach; ?>
    </tr>
  </tbody>
</table>
</div>
<script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script>