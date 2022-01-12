<nav class="sidebar">
      <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
        <span>HTQLNS</span>
        </a>
        <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="sidebar-body">
        <ul class="nav">
          <li class="nav-item nav-category">Trang Chủ</li>
          <li class="nav-item">
            <a href="<?php homePath();?>?page=home" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Trang Chủ</span>
            </a>
          </li>
          <li class="nav-item nav-category">Quản lý</li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#account" role="button" aria-expanded="false" aria-controls="account">
              <i class="link-icon" data-feather="mail"></i>
              <span class="link-title">Quản lý</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="account">
              <ul class="nav sub-menu">
                <?php if (checkPermission("god"))
                  {
                ?>
                  <li class="nav-item">
                    <a href="<?php homePath();?>?page=pages/account/accountlist" class="nav-link">Quản lý tài khoản</a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php homePath();?>?page=pages/account/phongban" class="nav-link">Quản lý phòng ban</a>
                  </li>
                <?php
                  }
                ?>

                <?php if (!checkPermission("god"))
                  {
                ?>
                  <li class="nav-item">
                    <a href="<?php homePath();?>?page=pages/task/manager" class="nav-link">Quản lý Task</a>
                  </li>
                <?php
                  }
                ?>

                <?php if (checkPermission("user"))
                  {
                ?>
                  <li class="nav-item">
                    <a href="<?php homePath();?>?page=pages/account/editprofile" class="nav-link">Sửa thông tin tài khoản</a>
                  </li>
                <?php
                  }
                ?>
              </ul>
            </div>
          </li>
          
          <li class="nav-item nav-category">Nghỉ phép</li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#absent" role="button" aria-expanded="false" aria-controls="account">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Nghỉ phép</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="absent">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="<?php homePath();?>?page=pages/absent/manager" class="nav-link">Quản lý nghỉ phép</a>
                </li>
              </ul>
              </div>
          </li>
         
        </ul>
      </div>
    </nav>