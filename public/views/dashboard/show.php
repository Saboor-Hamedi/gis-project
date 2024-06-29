<?php
use blog\services\auth\Auth;

path('layout/main');
use Carbon\Carbon;
use blog\functions\CSRF;
use Illuminate\Support\Str;
?>
<?php use blog\services\Message; ?>
<?php $message = new Message(); ?>
<?php $message->displayMessage(); ?>
<?php $auth = new Auth(); ?>
<?php path('layout/sidebar'); ?>
<div class="table__card">
    <div class="mt-auto mb-3">
        <a href="<?php url("/dashboard/admin"); ?>" class="btn btn-sm btn-secondary">Go Back</a>
    </div>
    <h2><?php echo upper($auth->username()); ?></h2>
    <div class="post__header">
        <h5 class="card-title"><?php echo upper($post[0]['title']); ?></h5>
    </div>
    <p class="card-text mb-0"><?php echo $post[0]['content']; ?></p>
    <small class="post__time"><?php echo Carbon::parse(upper($post[0]['created_at']))->diffForHumans(); ?></small>
</div>
<?php path('layout/links'); ?>