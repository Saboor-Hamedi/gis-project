<?php path('layout/main');
use Carbon\Carbon; 
use blog\functions\CSRF;
use Illuminate\Support\Str;
?>
<div class="login-card" style="max-width: 80%">
  <?php use blog\services\Message; ?>
  <?php $message = new Message(); ?>
  <?php $message->displayMessage(); ?>
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
        <?php foreach ($users as $user): ?>
          <td><?php echo $user['username'] ?></td>
          <td><?php echo $user['email'] ?></td>
        <?php endforeach; ?>
      </tr>
    </tbody>
  </table>
</div>
<!-- posts -->
<div class="container" style="max-width: 80%">
  <div class="row">
    <?php foreach ($posts as $post) : ?>
      <div class="col-md-4 mb-2 card-container">
        <div class="card h-100 d-flex flex-column overflow-hidden shadow-sm rounded-lg">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo $post['title']; ?></h5>
            <p class="card-text mb-0"><?php echo Str::limit($post['content'], 40); ?>
            </p>
            <small class="mb-2"><?php echo Carbon::parse($post['created_at'])->diffForHumans(); ?></small>

            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center">
                <a href="<?php url("/students/create"); ?>" class="btn btn-sm btn-primary">Create</a>
                <div class="d-flex">
                  <a href="/students/show/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-secondary me-2">Read</a>
                  <a href="/students/update/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                  <form action="<?php url('/posts/delete/' . $post['id']); ?>" method="POST" style="display:inline;">
                  <?php CSRF::generate(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
<script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script>