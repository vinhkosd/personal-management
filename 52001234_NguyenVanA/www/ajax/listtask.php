<?php
include __DIR__.'/../app/index.php';
use Models\Tasks;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
validateLogin(true, false);//check account login
requirePerm("user");

$accountList = Tasks::query();

$accountList->leftJoin('users', 'users.id', '=', 'tasks.owner_id');
$accountList->leftJoin(DB::raw('users users2'), 'users2.id', '=', 'tasks.assign_id');

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
            $accountList->orWhereRaw("cast(".$value['data']." as CHAR) like '%$searchText%'");
        }
    }
}

if(!empty($orderBy) && !empty($orderBy['data']) && $orderBy['orderable']) {
    $columnOrder = $orderBy['data'];
    $accountList->orderBy($orderBy['data'], $typeOrder);
}

if(!checkPermission("admin")) {//user
    $accountList->where("assign_id", $_SESSION['accountId']);
    $accountList->where("status", "<>", 2);
}

if($_SESSION["role"] == "admin") {//trưởng phòng
    $accountList->where("users.phongban_id", $_SESSION['phongban_id']);
}

$columns = [
    'tasks.*',
    'users.name as owner',
    'users2.name as assign',
];

$dataReturn = getPartial($accountList, $limit, $page, $columns);
$dataReturn['draw'] = $_GET['draw'] ?? null;
$dataReturn['recordsTotal'] = $dataReturn['totalRecord'];
$dataReturn['recordsFiltered'] = $dataReturn['totalRecord'];
echo(json_encode($dataReturn));
?>