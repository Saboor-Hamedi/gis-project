<?php path('layout/main'); ;?>
<?php use blog\functions\CSRF;?>
<div class="container mt-3 rounded-3" style="max-width: 800px; background: #f8f9fa">
  <div class="row">
    <div class="col-md-12">
      <form action="<?php url('/posts/store'); ?>" method="POST">
        <?php CSRF::generate(); ?>
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="title" placeholder="Your title">
        </div>
        <div class="mb-3">
          <label for="content" class="form-label" >Your content</label>
          <textarea class="form-control" name="content" id="content" rows="3"></textarea>
        </div>
        <div class="custom__card__footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script>
