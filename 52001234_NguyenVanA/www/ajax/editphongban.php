<?php
include __DIR__.'/../app/index.php';
use Models\PhongBan;
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login
requirePerm("god");

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'ten', 'mo_ta', 'so_phong', 'manager_id'])->toArray();
    $input['manager_id'] = intval($input['manager_id']);

    if(!is_numeric($input['manager_id'])) {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
    }

    $phongbanInfo = PhongBan::where('id', $input['id'])->first();

    if($input['manager_id'] > 0) {//setup trưởng phòng
        $accountInfo = Users::where('id', $input['manager_id'])->first();

        if($accountInfo['role'] == "god") {
            echo(json_encode(['error' => 'Giám đốc không thể làm trưởng phòng!']));
            die();
        }

        $phongBanOfManager = PhongBan::where('manager_id', $input['manager_id'])->first();

        if(!empty($phongBanOfManager)){//nhân viên này đã quản lý 1 phòng ban khác -> xoá user khỏi phòng ban cũ
            $updatePhongBan = [
                'manager_id' => 0
            ];

            $updateUser = [
                'phongban_id' => $input['id']
            ];

            PhongBan::where('manager_id', $input['manager_id'])->update($updatePhongBan);
            Users::where('id', $input['manager_id'])->update($updateUser);
        }
    }

    if($phongbanInfo['manager_id'] > 0 && $input['manager_id'] != $phongbanInfo['manager_id']) {//nhân viên bị tước chức trưởng phòng
        $accountInfo = Users::where('id', $input['manager_id'])->first();
        
        // $updatePhongBan = [
        //     'manager_id' => $input['manager_id']
        // ];

        $updateUserOld = [
            'phongban_id' => 0,
            'role' => 'user'
        ];

        // PhongBan::where('id', $input['id'])->update($updatePhongBan);
        Users::where('id', $phongbanInfo['manager_id'])->update($updateUserOld);
    }

    if ($input['manager_id'] > 0) {
        $updateUserNew = [
            'phongban_id' => $input['id'],
            'role' => 'admin'
        ];

        Users::where('id', $input['manager_id'])->update($updateUserNew);
    }

    if(empty($phongbanInfo)){
        echo(json_encode(['error' => 'Phòng ban không tồn tại vui lòng thử lại!']));
    } else {
        PhongBan::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Sửa phòng ban '.$phongbanInfo['ten'].' thành công']));
    }
}
?>