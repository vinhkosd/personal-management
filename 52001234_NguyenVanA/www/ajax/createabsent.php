<?php
include __DIR__.'/../app/index.php';
use Models\Absent;
use Models\Users;
use Illuminate\Support\Collection;
use Carbon\Carbon;
validateLogin(true, false);//check account login

if(isset($_POST)){
    if($_SESSION["role"] == "god") {
        echo(json_encode(['error' => 'Giám đốc không thể tạo đơn nghỉ phép!']));
        die();
    }

    $input = collect($_POST)->only(['reason', 'countdate'])->toArray();
    $input['countdate'] = intval($input['countdate']);

    if(!is_numeric($input['countdate'])) {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ!']));
    }

    $currentPendingAbsent = Absent::where("register_id", $_SESSION['accountId'])->orderBy("time", "desc")->first();

    if(!empty($currentPendingAbsent)) {
        if($currentPendingAbsent['status'] == 0) {
            echo(json_encode(['error' => 'Bạn đang có 1 đơn xin nghỉ phép chưa được duyệt, không thể đăng ký nghỉ phép!']));
            die();
        }

        $dateNow = Carbon::now();

        $lastAbsentRegTime = Carbon::parse($currentPendingAbsent['time'])->addDays(7);
        var_dump($dateNow->diffInMinutes($lastAbsentRegTime, false));
        die();
        if($dateNow->diffInMinutes($lastAbsentRegTime, false) > 0) {
            echo(json_encode(['error' => 'Mỗi 7 ngày mới được đăng ký nghỉ phép 1 lần, không thể đăng ký nghỉ phép!']));
            die();
        }

        $absentMax = $_SESSION["role"] == "admin" ? 15 : 12;
        $totalAbsent = Absent::where("register_id", $_SESSION['accountId'])->whereRaw("YEAR(time) > YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))")->count();
        if($totalAbsent >= $absentMax) {
            echo(json_encode(['error' => 'Bạn đã đăng ký hết số ngày nghỉ phép trong năm!']));
            die();
        }
    }

    $_SESSION['absenttmpfiles'] = !empty($_SESSION['absenttmpfiles']) ? $_SESSION['absenttmpfiles'] : [];
    $_SESSION['acceptabsenttmpfiles'] = true;

    $input['attachment'] = json_encode($_SESSION['absenttmpfiles']);
    $input['register_id'] = $_SESSION['accountId'];
    $input['status'] = 0;
    $input['time'] = Carbon::now();
    Absent::insert($input);
    echo(json_encode(['success' => 'Đăng ký nghỉ phép thành công!']));
}
?>