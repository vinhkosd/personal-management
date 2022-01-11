<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Models\Users;
use Illuminate\Support\Collection;
use Carbon\Carbon;
validateLogin(true, false);//check account login
requirePerm("admin");

if(isset($_POST)){
    $input = collect($_POST)->only(['id', 'complete_level'])->toArray();

    $taskInfo = Tasks::where('id', $input['id'])->first();

    if(empty($taskInfo)){
        echo(json_encode(['error' => 'Task không tồn tại vui lòng thử lại!']));
    } else {
        if($taskInfo['status'] == 5) {//task đã xong
            echo(json_encode(['error' => 'Task này đã làm xong, không thể bắt đầu!']));
            die();
        }

        if($taskInfo['status'] == 2) {//task đã bị huỷ
            echo(json_encode(['error' => 'Task này đã bị huỷ!']));
            die();
        }

        $dateNow = Carbon::now();

        $deadlineDate = Carbon::parse($taskInfo['time']);
        if($dateNow->diffInMinutes($deadlineDate, false) < 0 && $input['complete_level'] == 2) {
            echo(json_encode(['success' => 'Task hoàn thành không đúng thời hạn, không thể chọn mức độ này!']));
            die();
        }

        $input['status'] = 5;

        Tasks::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Hoàn thành task '.$taskInfo['ten'].' thành công']));
    }
}
?>