<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Models\Users;
use Illuminate\Support\Collection;
use Carbon\Carbon;
validateLogin(true, false);//check account login
requirePerm("admin");

if(isset($_POST)){
    $input = collect($_POST)->only(['id'])->toArray();

    if(!is_numeric($input['id'])) {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
        die();
    }
    
    

    $taskInfo = Tasks::where('id', $input['id'])->first();


    $_SESSION['tmpfiles'] = !empty($_SESSION['tmpfiles']) ? $_SESSION['tmpfiles'] : [];
    $_SESSION['accepttmpfiles'] = true;

    if(empty($taskInfo)){
        echo(json_encode(['error' => 'Task không tồn tại vui lòng thử lại!']));
    } else {
        $rejectStatus = 0;
        if ($taskInfo['status'] == 0) {
            $rejectStatus = 2;//cancel
        } else {
            $rejectStatus = 4;//reject
        }
        $taskUpdateParams = [
            'status' => $rejectStatus
        ];
        Tasks::where('id', $input['id'])->update($taskUpdateParams);
        echo(json_encode(['success' => 'Từ chối task "'.$taskInfo['ten'].'" thành công']));
        
    }
}
?>