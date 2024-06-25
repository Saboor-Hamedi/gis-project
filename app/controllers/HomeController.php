<?php
declare(strict_types=1);

namespace blog\controllers;
use blog\controllers\Controller;
use blog\model\banner\BannerModel;
use blog\model\PostModel;
class HomeController extends Controller
{

  public function index()
  {
    $banner = new BannerModel();
    $post = new PostModel();
    $posts = $post->all(3, 0, 'created_at', 'DESC');


    $banners = $banner->getAllBanners();
    $this->views('/home', ['posts' => $posts,'banners' => $banners]);
  }
 
}
