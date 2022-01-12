<?php
include __DIR__.'/../app/index.php';
use Models\Absent;
use Models\Users;
use Illuminate\Support\Collection;
use Carbon\Carbon;
validateLogin(true, false);//check account login
requirePerm("admin");

if(isset($_POST)){
    $input = collect($_POST)->only(['id'])->toArray();

    if(!is_numeric($input['id'])) {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
    }

    $columns = [
        'absent.*',
        'users.name as register_name',
        'users.phongban_id as users_phongban_id',
        'users.role as users_role',
    ];

    $currentPendingAbsent = Absent::where("absent.id", $input['id'])->leftJoin('users', 'users.id', '=', 'absent.register_id')->first($columns);

    if(empty($currentPendingAbsent)) {
        echo(json_encode(['error' => 'Thông tin đơn xin phép không tồn tại, vui lòng thử lại sau!']));
        die();
    }

    if($currentPendingAbsent['status'] != 0) {
        echo(json_encode(['error' => 'Đơn này đã được xử lý!']));
        die();
    }

    if($currentPendingAbsent['users_role'] == 'admin' && $_SESSION['role'] != 'god') {
        echo(json_encode(['error' => 'Trưởng phòng không thể duyệt đơn của trưởng phòng!']));
        die();
    }

    if($currentPendingAbsent['users_role'] == 'user' && $_SESSION['role'] != 'admin') {
        echo(json_encode(['error' => 'Chỉ có trưởng phòng mới có thể duyệt đơn của nhân viên!']));
        die();
    }

    if($currentPendingAbsent['users_role'] == 'user' && $currentPendingAbsent['users_phongban_id'] != $_SESSION['phongban_id']) {
        echo(json_encode(['error' => 'Đơn này không thuộc phòng ban của bạn!']));
        die();
    }

    $input['status'] = 1;
    Absent::where("absent.id", $input['id'])->update($input);
    echo(json_encode(['success' => 'Đồng ý đơn nghỉ phép thành công!']));
}
?>