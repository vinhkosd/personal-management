<?php
include __DIR__.'/../app/index.php';
use Models\Users;
validateLogin(true, false);

if(isset($_POST)){
    $username = $_SESSION['username'];
    $password = md5($_POST['password']);
    $whereClause = [
        'username' => $username,
        'isFirst' => true
    ];

    $accountInfo = Users::where($whereClause)->first();
    if(!empty($accountInfo)) {
        if ($_POST['password'] == $_SESSION['username']) {
            echo(json_encode(['error' => 'Mật khẩu không được trùng với tài khoản']));
        } else {
            $input = [];
            $input['password'] = $password;
            $input['isFirst'] = false;
            $_SESSION['isFirst'] = false;
            Users::where('id', $accountInfo['id'])->update($input);
            echo(json_encode(['success']));
        }
        
    } else {
        echo(json_encode(['error' => 'Dữ liệu không hợp lệ']));
    }
}
?>