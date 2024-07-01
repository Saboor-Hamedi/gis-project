<?php

declare(strict_types=1);

namespace blog\controllers;

use blog\controllers\Controller;
use blog\model\banner\BannerModel;
use blog\model\PostModel;
use blog\services\auth\Auth;
use blog\services\Html\InputUtilized;
use blog\services\Message;
use blog\services\ResponseCode;

class HomeController extends Controller
{
  protected $postModel;
  protected $message;
  protected $auth;
  use ResponseCode;
  public function __construct()
  {
    $this->postModel = new PostModel();
    $this->message = new Message();
    $this->auth = new Auth();
  }

  public function index()
  {
    $banner = new BannerModel();
    $banners = $banner->getAllBanners();
    $posts = $this->postModel->allWithUser(null, 0, 'created_at', 'desc');
    $this->views('/home', ['posts' => $posts, 'banners' => $banners]);
  }
  public function show($id)
  {
    $post_id = InputUtilized::sanitizeInput($id, 'int');
    if (!$post_id) {
      $this->sendResponse(self::BAD_REQUEST, 'Invalid ID');
      return;
    }
    $post = $this->postModel->singlePostWithUser($post_id);
    // post exists
    if (!$post) {
      $this->sendResponse(self::NOT_FOUND, 'Post not found');
      return;
    }
    $this->views('/posts/show', ['post' => $post]);
  }
}
