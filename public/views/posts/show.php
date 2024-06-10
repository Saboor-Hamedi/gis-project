<?php path('layout/main');; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-8 mb-5 card-container">
      <div class="card h-100 d-flex flex-column overflow-hidden shadow-sm rounded-lg">
        <div class="card-body d-flex flex-column">
          <div class="mt-auto mb-3">
            <a href="<?php url("/"); ?>" class="btn btn-sm btn-secondary">Go Back</a>
          </div>
          <h5 class="card-title"><?php echo $post['title']; ?></h5>
          <p class="card-text"><?php echo $post['content']; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php assets('js/bootstrap.bundle.min.js'); ?>"></script>
