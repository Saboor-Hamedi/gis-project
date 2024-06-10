<?php

declare(strict_types=1);
// load js/css
function assets($path, $base_url = '')
{
  // If base URL is not provided, use the current URL
  if (empty($base_url)) {
    $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $base_url .= $_SERVER['HTTP_HOST'];
  }
  // Generate URL dynamically
  $url = rtrim($base_url, '/') . '/public/assets/' . ltrim($path);
  echo $url;
}

// images
function images($path, $base_url = '')
{
  // If base URL is not provided, use the current URL
  if (empty($base_url)) {
    $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $base_url .= $_SERVER['HTTP_HOST'];
  }
  // Specify the base directory for images
  $url = rtrim($base_url, '/') . '/public/assets/' . ltrim($path);
  echo $url;
}

// header
