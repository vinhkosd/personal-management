<?php
validateLogin(true, true);
?>

<div class="page-content d-flex align-items-center justify-content-center">
  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-12 pl-md-3">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="ui-logo logo-light d-block mb-2">HỆ THỐNG QUẢN LÝ NHÂN SỰ</a>
              <h5 class="text-muted font-weight-normal mb-4">Vui lòng tạo tài khoản cho lần đầu sử dụng phần mềm.</h5>
              <form id="firstLoginForm" class="needs-validation" method="post">
                <div class="form-group has-feedback">
                  <label for="name" class="control-label">Họ tên giám đốc</label>
                  <input type="text" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s|_]+$" maxlength="60" class="form-control" id="name" name="name" placeholder="Họ tên giám đốc" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group has-feedback">
                  <label for="imageurl">Ảnh đại diện</label>
                  <input class="form-control" type="file" id="imageurl" name="imageurl" class="border" accept="image/*"/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group has-feedback">
                  <label for="username" class="control-label">Tài khoản giám đốc</label>
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
                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                    Tạo tài khoản
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