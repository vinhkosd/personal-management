<?php
include __DIR__.'/../app/index.php';
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['password', 'repassword'])->toArray();

    $accountInfo = Users::where('username', $_SESSION['username'])->first();

    if ($input['password'] == $_SESSION['username']) {//nếu mật khẩu không thay đổi thì không update vào database
        unset($input['password']);
    } else {
        if($input['password'] != $input['repassword']) {
            echo(json_encode(['error' => 'Nhập lại mật khẩu mới không đúng, vui lòng thử lại!']));
            die();
        }

        $input['password'] = md5($input['password']);
        if($input['password'] == $accountInfo['password']) {
            echo(json_encode(['error' => 'Mật khẩu không được trùng với mật khẩu cũ!']));
            die();
        }
    }

    unset($input['repassword']);

    if(empty($accountInfo)){
        echo(json_encode(['error' => 'Tài khoản không tồn tại. Vui lòng đăng xuất ra và thử lại!']));
    } else {
        if (isset($_FILES["imageurl"]) && !empty($_FILES["imageurl"]) && !empty($_FILES["imageurl"]["tmp_name"])) {
            if($_FILES['imageurl']['size'] > 5 * 1024 * 1024) {
                echo(json_encode(['error' => 'Kích thước file vượt quá 5mb!']));
                die();
            }

            $check = getimagesize($_FILES["imageurl"]["tmp_name"]);

            $target_dir = "../uploads/";
            $target_file = $target_dir . $_SESSION['username']. "-" . time() . "-" . basename($_FILES["imageurl"]["name"]);
            $imageurl = "uploads/" . $_SESSION['username']. "-" . time() . "-" . basename($_FILES["imageurl"]["name"]);

            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($check !== false && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")) {
                $uploadOk = true;
            } else {
                $uploadOk = false;
            }

            if($uploadOk) {//check ảnh đại diện hợp lệ
                if (move_uploaded_file($_FILES["imageurl"]["tmp_name"], $target_file)) {
                    $input['imageurl'] = $imageurl;
                    $_SESSION['imageurl'] = $imageurl;
                } else {
                    echo(json_encode(['error' => 'Không thể upload ảnh đại diện, vui lòng thử lại hoặc liên hệ quản trị viên.']));
                    die();
                }
            } else {
                echo(json_encode(['error' => 'Tệp tải lên có định dạng không hợp lệ (yêu cầu: tệp ảnh có định dạng .png, .jpeg, .jpg, .gif).']));
                die();
            }
        }
        
        if(count($input) > 0) {
            Users::where('username', $_SESSION['username'])->update($input);
            echo(json_encode(['success' => 'Sửa tài khoản '.$accountInfo['username'].' thành công.']));
        } else {
            echo(json_encode(['error' => 'Không có gì để cập nhật!']));
        }

        
    }
}
?>