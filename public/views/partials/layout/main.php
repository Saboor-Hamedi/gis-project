<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo assets('css/bootstrap.min.css'); ?>">
  <title>Hello World</title>
</head>
<body>
    <?php  path('layout/navbar'); ?>
  <main>
    <?php path('layout/banner');?>
    
  </main>
  <?php  path('layout/footer'); ?>
  <script src="<?php echo assets('js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>
