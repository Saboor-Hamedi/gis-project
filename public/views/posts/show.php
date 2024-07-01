<?php

use blog\services\auth\Auth;

path('layout/frontPage');

use Carbon\Carbon;
?>
<?php

use blog\services\Message; ?>
<?php $message = new Message(); ?>
<?php $auth = new Auth(); ?>
<div class="table__card">
    <?php $message->displayMessage(); ?>
    <div class="mt-auto mb-3">
        <a href="<?php url("/"); ?>" class="btn btn-sm btn-secondary">Go Back</a>
    </div>
    <h2><?php echo upper($post['username'] ?? ''); ?></h2>
    <div class="post__header">
        <h5 class="card-title"><?php echo (upper($post['title']) ?? ''); ?></h5>

    </div>
    <p class="card-text mb-0"><?php echo (upper($post['content']) ?? ''); ?></p>

    <small class="post__time"><?php echo Carbon::parse(upper($post['created_at']) ?? '')->diffForHumans(); ?></small>
</div>
<?php path('layout/links'); ?>