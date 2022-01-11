<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Models\Users;
use Illuminate\Support\Collection;
use Carbon\Carbon;
validateLogin(true, false);//check account login

if(isset($_POST)){
    if(checkPermission("user")) {
        $input = collect($_POST)->only(['id'])->toArray();

        if(!is_numeric($input['id'])) {
            echo(json_encode(['error' => 'ID Task không hợp lệ!']));
            die();
        }
    }
    else {
        echo(json_encode(['error' => 'Bạn phải là nhân viên mới có thể nhận task!']));
        die();
    }

    $taskInfo = Tasks::where('id', $input['id'])->first();

    $_SESSION['tmpfiles'] = !empty($_SESSION['tmpfiles']) ? $_SESSION['tmpfiles'] : [];
    $_SESSION['accepttmpfiles'] = true;

    if(empty($taskInfo)){
        echo(json_encode(['error' => 'Task không tồn tại vui lòng thử lại!']));
    } else {
        if($taskInfo['status'] == 2) {//phải nhận task và task chưa bị huỷ
            echo(json_encode(['error' => 'Task này đã bị huỷ!']));
            die();
        }

        if($taskInfo['status'] == 5) {//task đã xong
            echo(json_encode(['error' => 'Task này đã làm xong, không thể bắt đầu!']));
            die();
        }
        
        if($taskInfo['status'] == 0) {//new task
            if ($taskInfo['assign_id'] == $_SESSION['accountId']) {
                $dateNow = Carbon::now();
                $deadlineDate = Carbon::parse($taskInfo['time']);
                if($dateNow->diffInMinutes($deadlineDate, false) < 0) {
                    echo(json_encode(['error' => 'Task này đã hết thời hạn!']));
                } else {
                    $taskUpdateParams = [
                        'status' => 1
                    ];
                    Tasks::where('id', $input['id'])->update($taskUpdateParams);
                    echo(json_encode(['success' => 'Nhận task "'.$taskInfo['ten'].'" thành công']));
                }
                
            } else {
                echo(json_encode(['error' => 'Task này không phải của bạn!']));
            }
            
        } else {
            echo(json_encode(['error' => 'Task đang làm, không thể nhận task này!']));
        }
    }
}
?>