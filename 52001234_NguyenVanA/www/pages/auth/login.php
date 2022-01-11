<?php
use Models\Users;
validateLogin(true, true);
$countUsers = Users::count();

if($countUsers <= 0) {
  redirectRoute('pages/auth/firstlogin');
}
?>

<div class="page-content d-flex align-items-center justify-content-center">
  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-12 pl-md-3">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="ui-logo logo-light d-block mb-2">HỆ THỐNG QUẢN LÝ NHÂN SỰ</a>
              <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
              <form id="loginForm" class="needs-validation" method="post">
                <div class="form-group has-feedback">
                  <label for="username" class="control-label">Tài khoản</label>
                  <input type="text"  pattern="^[_A-z0-9.]{1,}$" maxlength="60" class="form-control" id="username" name="username" placeholder="Tài khoản" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <label for="password">Password</label>
                  <input type="password" pattern="^[_A-z0-9]{1,}$" maxlength="60" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <!--div class="form-check form-check-flat form-check-primary">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input">
                    Remember me
                  </label>
                </div-->
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                    Login
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>