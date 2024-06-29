<?php
declare(strict_types=1);

namespace blog\controllers;

use blog\controllers\Controller;
use blog\model\banner\BannerModel;
use blog\model\PostModel;

class HomeController extends Controller
{
  protected $postModel;
  public function __construct()
  {
    $this->postModel = new PostModel();
  }

  public function index()
  {
    $banner = new BannerModel();
    $posts = $this->postModel->all(null, 0, 'created_at', 'desc');
    $banners = $banner->getAllBanners();
    $this->views('/home', ['posts' => $posts, 'banners' => $banners]);
  }

}
