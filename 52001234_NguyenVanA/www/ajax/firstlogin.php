<?php
include __DIR__.'/../app/index.php';
use Models\Users;
use Illuminate\Support\Collection;

if(isset($_POST)){
    $input = collect($_POST)->only(['name', 'username', 'password'])->toArray();

    $countUsers = Users::count();

    if($countUsers > 0) {
        echo(json_encode(['error' => 'Tính năng chỉ sử dụng cho lần đầu cài đặt phần mềm!']));
        die();
    }


    $input['password'] = md5($input['password']);
    if($input['password'] == $input['username']) {
        echo(json_encode(['error' => 'Mật khẩu không được trùng với tài khoản!']));
        die();
    }
    

   
    if (isset($_FILES["imageurl"]) && !empty($_FILES["imageurl"]) && !empty($_FILES["imageurl"]["tmp_name"])) {
        if($_FILES['imageurl']['size'] > 5 * 1024 * 1024) {
            echo(json_encode(['error' => 'Kích thước file vượt quá 5mb!']));
            die();
        }

        $check = getimagesize($_FILES["imageurl"]["tmp_name"]);

        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $input['username']. "-" . time() . "-" . basename($_FILES["imageurl"]["name"]);
        $imageurl = "uploads/" . $input['username']. "-" . time() . "-" . basename($_FILES["imageurl"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($check !== false && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")) {
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }

        if($uploadOk) {//check ảnh đại diện hợp lệ
            if (move_uploaded_file($_FILES["imageurl"]["tmp_name"], $target_file)) {
                $input['imageurl'] = $imageurl;
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
        $input['isFirst'] = false;
        $input['role'] = 'god';

        Users::insert($input);

        $whereClause = [
            'username' => $input['username'],
            'password' => $input['password'],
        ];
        $accountInfo = Users::where($whereClause)->first();

        $_SESSION['accountId'] = $accountInfo['id'];
        $_SESSION['username'] = $input['username'];
        $_SESSION['accountName'] = $accountInfo['name'];
        $_SESSION['password'] = $input['password'];
        $_SESSION['imageurl'] = !empty($accountInfo['imageurl']) ? $accountInfo['imageurl'] : "https://via.placeholder.com/100x100";
        $_SESSION['role'] = $accountInfo['role'];
        $_SESSION['phongban_id'] = $accountInfo['phongban_id'];
        $_SESSION['isFirst'] = boolval($accountInfo['isFirst']);

        echo(json_encode(['success' => 'Tạo tài khoản giám đốc '.$accountInfo['username'].' thành công.']));
    }

        
    
}
?>