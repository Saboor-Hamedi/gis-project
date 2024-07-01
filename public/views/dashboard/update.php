<?php path('layout/main'); ?>
<?php path('layout/sidebar'); ?>
<?php

use blog\functions\CSRF; ?>

<div class="table__card">

  <div class="row">
    <div class="col-md-12">
      <form action="<?php url('/dashboard/edit') ?>" method="POST">
        <?php CSRF::generate(); ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="mb-3 mt-3">
          <input type="hidden" class="form-control" name="id" value="<?php echo $post[0]['id'] ?? ''; ?>">
        </div>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="title" value="<?php echo $post[0]['title'] ?? ''; ?>" placeholder="Your title">
          <?php error($errors, 'title'); ?>
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Your content</label>
          <textarea class="form-control" name="content" id="content" rows="3"><?php echo $post[0]['content'] ?? ''; ?></textarea>
          <?php error($errors, 'content'); ?>
        </div>
        <div class="custom__card__footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php path('layout/links'); ?>