<?php
    use Models\Users;
    validateLogin(true, false);//check account login
    $accountInfo = Users::where('username', $_SESSION['username'])
                  ->leftJoin('phongban', 'phongban.id', '=', 'users.phongban_id')
                  ->first(["phongban.ten"]);
?>

<div class="page-content d-flex align-items-center justify-content-center">
  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-12 pl-md-3">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="ui-logo logo-light d-block mb-2">HỆ THỐNG QUẢN LÝ NHÂN SỰ</a>
              <h5 class="text-muted font-weight-normal mb-4">Sửa thông tin tài khoản.</h5>
              <form id="editProfileForm" class="needs-validation" method="post">
                <div class="form-group has-feedback">
                  <label for="username">Tài khoản</label>
                  <input value="<?php echo $_SESSION['username'];?>" type="text" class="form-control" id="username" name="username" autocomplete="current-username" placeholder="Tài khoản" readonly/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <label for="name">Họ tên</label>
                  <input value="<?php echo $_SESSION['accountName'];?>" type="text" class="form-control" id="name" name="name" autocomplete="current-name" placeholder="Họ và tên" readonly/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <label for="role">Quyền hạn</label>
                  <input value="<?php echo roleTitle[$_SESSION['role']];?>" type="text" class="form-control" id="role" name="role" autocomplete="current-role" placeholder="Quyền hạn" readonly/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group has-feedback">
                  <label for="phongban_id">Phòng ban</label>
                  <input value="<?php echo $accountInfo["ten"] ?? "";?>" type="text" class="form-control" id="phongban_id" name="phongban_id" autocomplete="current-phongban_id" placeholder="Phòng ban" readonly/>
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
                  <label for="password">Mật khẩu</label>
                  <input value="<?php echo $_SESSION['username'];?>" type="password" pattern="^[_A-z0-9]{1,}$" maxlength="60" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password" required/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
                <div class="form-group has-feedback">
                  <label for="repassword">Nhập lại mật khẩu</label>
                  <input value="" type="password" pattern="^[_A-z0-9]{1,}$" maxlength="60" class="form-control" id="repassword" name="repassword" autocomplete="current-repassword" placeholder="Nếu không thay đổi gì thì không cần nhập vào ô này"/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                    Sửa
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
<script type="text/javascript">
$().ready(function() {
  $('#editProfileForm').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
      return false;
    }
    
    var formData = new FormData();
    var currentForm = $( "#editProfileForm" ).serializeArray()
    console.log(currentForm)
    console.log(Object.values(currentForm))
    currentForm.map(item => {
      formData.append(item.name, item.value);
    })

    attachment_data= $("#imageurl")[0].files[0];
    formData.append("imageurl", attachment_data);

    $.ajax({
      url : window.homePath + "ajax/editprofile.php",
      type : 'POST',
      data : formData,
      processData: false,  // tell jQuery not to process the data
      contentType: false,  // tell jQuery not to set contentType
      success : function(data) {
        var result = JSON.parse(data)
        if(result.success) {
          Lobibox.notify("success", {
            msg: result["success"]
          });
        } else {
          Lobibox.notify("error", {
            msg: result["error"]
          });
        }
      }
    });

    return false;
  });
});
</script>
