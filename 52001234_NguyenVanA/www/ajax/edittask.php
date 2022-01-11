<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    if(checkPermission("admin")) {
        $input = collect($_POST)->only(['id', 'ten', 'mo_ta', 'so_phong', 'assign_id', 'time'])->toArray();
        $input['assign_id'] = intval($input['assign_id']);

        if(!is_numeric($input['assign_id'])) {
            echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
        }
    }
    else {
        $input = collect($_POST)->only(['id', 'mo_ta'])->toArray();
    }
    
    

    $taskInfo = Tasks::where('id', $input['id'])->first();

    

    $_SESSION['tmpfiles'] = !empty($_SESSION['tmpfiles']) ? $_SESSION['tmpfiles'] : [];
    $_SESSION['accepttmpfiles'] = true;

    if(empty($taskInfo)){
        echo(json_encode(['error' => 'Task không tồn tại vui lòng thử lại!']));
    } else {
        if($taskInfo['status'] == 5) {//task đã xong
            echo(json_encode(['error' => 'Task này đã làm xong, không thể bắt đầu!']));
            die();
        }

        if(!checkPermission("admin")) {//user
            if($taskInfo['status'] <= 0 || $taskInfo['status'] == 2) {//phải nhận task và task chưa bị huỷ
                echo(json_encode(['error' => 'Task chưa start hoặc đã bị huỷ không thể submit task!']));
                die();
            }
            
            $input['status'] = 3;
        }
        $taskInfo['attachment'] = !empty($taskInfo['attachment']) ? json_decode($taskInfo['attachment']) : [];
        $input['attachment'] = array_merge((array)$taskInfo['attachment'], (array)$_SESSION['tmpfiles']);
        $input['attachment'] = json_encode($input['attachment']);
        Tasks::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Sửa task '.$taskInfo['ten'].' thành công']));
    }
}
?>