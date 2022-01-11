<?php
include __DIR__.'/../app/index.php';
use Models\PhongBan;
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login
requirePerm("god");

if(isset($_POST)){
    $input = collect($_POST)->only(['ten', 'mo_ta', 'so_phong'])->toArray();
    $input['manager_id'] = 0;

    $phongbanInfo = PhongBan::where('ten', $input['ten'])->first();

    if(!empty($phongbanInfo)){
        echo(json_encode(['error' => 'Phòng ban '.$input['ten'].' đã tồn tại vui lòng sử dụng tên phòng ban khác!']));
    } else {
        PhongBan::insert($input);
        echo(json_encode(['success' => 'Tạo phòng ban '.$input['ten'].' thành công']));
    }
}
?>