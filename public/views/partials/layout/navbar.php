<?php

use blog\services\auth\Auth; ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php url('/') ?>">
      <img src="<?php assets('images/logo.png'); ?>" width="32" height="32" class="d-block me-2" viewBox="0 0 118 94"
        role="img">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?php $auth = new Auth(); ?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($auth->check() && $auth->hasRoles([0])): ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php url('/posts/create'); ?>">Create</a>
          </li>
          <?php else:?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php url('/students/create'); ?>">Create</a>
          </li>
        <?php endif; ?>
        <?php if (!$auth->check()): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php url('/login/login'); ?>">Login</a>
          </li>
        <?php endif; ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>

            <?php if ($auth->check()): ?>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form action="<?php url('/login/logout'); ?>" method="post">
                  <button type="submit" class="dropdown-item">Sign out</button>
                </form>
              </li>
            <?php endif; ?>
          </ul>
        </li>

      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>