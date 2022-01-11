<?php
include __DIR__.'/../app/index.php';
use Models\Users;
use Illuminate\Support\Collection;
validateLogin(true, false);//check account login

if(isset($_POST)){
    $input = collect($_POST)->only(['id'])->toArray();

    $accountInfo = Users::where('id', $input['id'])->first();
    
    if(empty($accountInfo)){
        echo(json_encode(['error' => 'Tài khoản không tồn tại. ID: '.$input['id']]));
    } else {
        $input['password'] = md5($accountInfo['username']);
        $input['isFirst'] = true;
        Users::where('id', $input['id'])->update($input);
        echo(json_encode(['success' => 'Đổi mật khẩu tài khoản '.$accountInfo['username'].' thành công.']));
    }
}
?>