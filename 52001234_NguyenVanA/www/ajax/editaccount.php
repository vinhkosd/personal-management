<?php
include __DIR__.'/../app/index.php';
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login
requirePerm("god");//check account role

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'imageurl', 'active', 'role', 'name', 'phongban_id'])->toArray();

    $accountInfo = Users::where('id', $input['id'])->first();

    $input['active'] = boolval($input['active']);

    if (!empty($input['role']) && !in_array($input['role'], ["admin", "user"])) {
        echo(json_encode(['error' => "Dữ liệu không hợp lệ, quyền hạn này không được cấp cho tài khoản cá nhân"]));
        die();
    }

    if ($accountInfo['username'] == $_SESSION['username']) {//nếu tài khoản là tài khoản giám đốc thì không cấp quyền user/trưởng phòng
        unset($input['role']);
    }

    if(empty($accountInfo)){
        echo(json_encode(['error' => 'Tài khoản không tồn tại. ID: '.$input['id']]));
    } else {
        Users::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Sửa tài khoản '.$accountInfo['username'].' thành công. ID: '.$input['id']]));
    }
}
?>