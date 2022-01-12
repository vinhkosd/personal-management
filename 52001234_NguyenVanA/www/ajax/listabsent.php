<?php
include __DIR__.'/../app/index.php';
use Models\Absent;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
validateLogin(true, false);//check account login
requirePerm("user");

$absentList = Absent::query();

$absentList->leftJoin('users', 'users.id', '=', 'absent.register_id');

$limit = $_GET['length'] ?? null;
$offset = $_GET['start'] ?? null;
$searchText = $_GET['search']['value'] ?? null;
$page = floor($offset/$limit) + 1;

$columns = $_GET['columns'] ?? [];
$orderBy = !empty($_GET['order']) && !empty($_GET['order'][0]) ? $columns[$_GET['order'][0]['column']] : false;
$typeOrder = !empty($_GET['order']) && !empty($_GET['order'][0]) && !empty($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] == 'asc' ? 'asc' : 'desc';
if(!empty($searchText)) {
    $whereClause = [];
    foreach($columns as $key => $value) {
        if(isset($value['searchable']) && filter_var($value['searchable'], FILTER_VALIDATE_BOOLEAN) && !empty($value['data'])) {
            $absentList->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
        }
    }
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $absentList->orderBy($orderBy['data'], $typeOrder);
}

if($_SESSION["role"] == "god") {//giám đốc
    $absentList->where("users.role", "admin");
}elseif($_SESSION["role"] == "admin") {//trưởng phòng
    $absentList->where("users.phongban_id", $_SESSION['phongban_id']);
    $absentList->where("users.role", "user");
}else{//user
    $absentList->where("absent.register_id", $_SESSION['accountId']);
}

$columns = [
    'absent.*',
    'users.name as register_name',
];

$dataReturn = getPartial($absentList, $limit, $page, $columns);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
if($_SESSION["role"] != "god") {
    $absentMax = $_SESSION["role"] == "admin" ? 15 : 12;
    $totalAbsent = Absent::where("register_id", $_SESSION['accountId'])->whereRaw("YEAR(time) > YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))")->count();
    $dataReturn['absentRemain'] = $absentMax - $totalAbsent;
    $dataReturn['absentTotal'] = $totalAbsent;
    $dataReturn['absentMax'] = $absentMax;
}
echo(json_encode($dataReturn));
?>