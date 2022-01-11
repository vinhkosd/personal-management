<?php
include __DIR__.'/../app/index.php';
use Models\Users;
use Models\PhongBan;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login
requirePerm("god");

if(isset($_POST)){
    $input = collect($_POST)->only(['name', 'imageurl', 'username', 'active', 'role', 'phongban_id'])->toArray();

    $phongBanInfo = Users::where('id', $input['phongban_id'])->first();

    $accountInfo = Users::where('username', $input['username'])->first();
    
    $input['active'] = boolval($input['active']);
    
    if(empty($phongBanInfo)) {
        echo(json_encode(['error' => 'Phòng ban không hợp lệ!']));
        die();
    }

    if(!empty($accountInfo)){
        echo(json_encode(['error' => 'Tài khoản '.$input['username'].' đã tồn tại vui lòng sử dụng tài khoản khác!']));
    } else {
        $input['isFirst'] = true;
        $input['password'] = md5($input['username']);
        Users::insert($input);
        echo(json_encode(['success' => 'Tạo tài khoản '.$input['username'].' thành công']));
    }
}
?>