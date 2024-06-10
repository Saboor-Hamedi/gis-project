<?php
      use blog\model\banner\BannerModel;
      $bannerModel = new BannerModel();
  ?>
<section class="py-5 text-center container">
  <div class="row py-lg-5">
   
    <?php if (!empty($banners)) : ?>
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"><?php echo $banners['title']; ?></h1>
        <p class="lead text-body-secondary"><?php echo $banners['content']; ?></p>
        <p>
          <a href="#" class="btn btn-primary my-2">Main call to action</a>
          <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p>
      </div>
    <?php else : ?>
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">No banners available</h1>
        <p class="lead text-body-secondary">There are currently no banners to display.</p>
      </div>
    <?php endif; ?>
  </div>
</section>
