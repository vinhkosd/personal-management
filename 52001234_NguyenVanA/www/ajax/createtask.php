<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login
requirePerm("admin");

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'ten', 'mo_ta', 'so_phong', 'assign_id', 'time'])->toArray();
    $input['assign_id'] = intval($input['assign_id']);

    if(!is_numeric($input['assign_id'])) {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
    }

    $_SESSION['tmpfiles'] = !empty($_SESSION['tmpfiles']) ? $_SESSION['tmpfiles'] : [];
    $_SESSION['accepttmpfiles'] = true;

    $input['attachment'] = json_encode($_SESSION['tmpfiles']);
    $input['owner_id'] = $_SESSION['accountId'];
    Tasks::insert($input);
    echo(json_encode(['success' => 'Tạo task '.$input['ten'].' thành công!']));
    
}
?>