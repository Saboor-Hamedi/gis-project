<?php

use Illuminate\Support\Str;
use Carbon\Carbon;
use blog\services\Message;

$msg = new Message();
?>
<?php
path('layout/frontPage');
?>

<?php path('layout/banner', ['banners' => $banners]); ?>
<div class="container">
  <div class="row">
    <?php foreach ($posts as $post) : ?>
      <div class="col-md-4 mb-2 card-container">
        <div class="card h-100 d-flex flex-column overflow-hidden shadow-sm rounded-lg">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo $post['title']; ?></h5>
            <p class="card-text mb-0"><?php echo Str::limit($post['content'], 40); ?>
            </p>
            <small class="mb-2"><?php echo Carbon::parse($post['created_at'])->diffForHumans(); ?></small>
            <?php echo $post['username']; ?>

            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex">
                  <a href="/posts/show/<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-secondary me-2">Read</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
<?php path('layout/links'); ?>
<?php path('layout/footer'); ?>