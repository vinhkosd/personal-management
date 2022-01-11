<?php
include __DIR__.'/../app/index.php';
use Models\Users;
validateLogin(true, true);

if(isset($_POST)){

    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $whereClause = [
        'username' => $username,
        'password' => $password,
    ];
    $accountInfo = Users::where($whereClause)->first();
    if(!empty($accountInfo)) {
        $_SESSION['accountId'] = $accountInfo['id'];
        $_SESSION['username'] = $username;
        $_SESSION['accountName'] = $accountInfo['name'];
        $_SESSION['password'] = $password;
        $_SESSION['imageurl'] = !empty($accountInfo['imageurl']) ? $accountInfo['imageurl'] : "https://via.placeholder.com/100x100";
        $_SESSION['role'] = $accountInfo['role'];
        $_SESSION['phongban_id'] = $accountInfo['phongban_id'];
        $_SESSION['isFirst'] = boolval($accountInfo['isFirst']);
        echo(json_encode(['success']));
    } else {
        echo(json_encode(['error' => 'Tài khoản hoặc mật khẩu không chính xác']));
    }
}
?>