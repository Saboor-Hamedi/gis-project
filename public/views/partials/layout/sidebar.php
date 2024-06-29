<?php use blog\services\auth\Auth; ?>
<?php $auth = new Auth(); ?>
<div class="wrapper">
  <div class="sidebar">
    <!-- <div class="profile">
      <img
        src="https://1.bp.blogspot.com/-vhmWFWO2r8U/YLjr2A57toI/AAAAAAAACO4/0GBonlEZPmAiQW4uvkCTm5LvlJVd_-l_wCNcBGAsYHQ/s16000/team-1-2.jpg"
        alt="profile_picture">
      <h3>Anamika Roy</h3>
      <p>Designer</p>
    </div> -->
    <ul class="navbar-nav">
      <?php if ($auth->check() && $auth->hasRoles([0])): ?>
        <li class="li__list__sidebar">
          <a href="<?php url('/dashboard/admin')?>" class="active ">
            <span class="icon"><i class="bi bi-house-check-fill"></i></span>
            <span class="item">Home</span>
          </a>
        </li>
      <?php elseif ($auth->check() && $auth->hasRoles([1])): ?>
        <li class="li__list__sidebar">
          <a href="<?php url('/students/index')?>" class="active ">
            <span class="icon"><i class="bi bi-house-check-fill"></i></span>
            <span class="item">Home</span>
          </a>
        </li>
      <?php endif; ?>
      <?php if ($auth->check() && $auth->hasRoles([0])): ?>
        <li class="nav-item">
          <a href="<?php url('/dashboard/create'); ?>" cassl="nav-link">
            <span class="icon"><i class="bi bi-code-square"></i></span>
            <span class="item">Create</span>
          </a>
        </li>
      <?php elseif ($auth->check() && $auth->hasRoles([1])): ?>
        <li class="nav-item">
          <a href="<?php url('/students/create'); ?>" cassl="nav-link">
            <span class="icon"><i class="bi bi-code-square"></i></span>
            <span class="item">Create</span>
          </a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-window-stack"></i></span>
          <span class="item">My Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-people-fill"></i></span>
          <span class="item">People</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-person-workspace"></i></span>
          <span class="item">Performance</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-database-down"></i></span>
          <span class="item">Development</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-card-list"></i></span>
          <span class="item">Reports</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-person-add"></i></span>
          <span class="item">Admin</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" cassl="nav-link">
          <span class="icon"><i class="bi bi-sliders"></i></span>
          <span class="item">Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <?php if ($auth->check()): ?>
          <form action="<?php url('/login/logout'); ?>" method="post">
            <button type="submit" class="logout-button">
              <span class="icon"><i class="bi bi-box-arrow-right"></i></span>
              <span class="item" style="margin-left: 10px;">Sign out</span>
            </button>
            <!-- <button type="submit">
              <i class="bi bi-box-arrow-right"></i>
            </button> -->
          </form>
        <?php endif; ?>
      </li>
    </ul>
  </div>
</div>