<?php path('layout/main'); ?>
<?php path('layout/sidebar'); ?>
<?php use blog\functions\CSRF; ?>

<div class="table__card">

  <div class="row">
    <div class="col-md-12">
      <form action="<?php url('/students/store'); ?>" method="POST">
        <?php CSRF::generate(); ?>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="title" placeholder="Your title">
          <?php error($errors, 'title'); ?>
        </div>
        <div class="mb-3">
          <label for="content" class="form-label">Your content</label>
          <textarea class="form-control" name="content" id="content" rows="3"></textarea>
          <?php error($errors, 'content'); ?>
        </div>
        <div class="custom__card__footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php assets('js/dark-mode.js'); ?>"></script>
<script src="<?php assets('js/side-bar.js'); ?>"></script>