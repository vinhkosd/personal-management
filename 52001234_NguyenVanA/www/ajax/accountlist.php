<?php
include __DIR__.'/../app/index.php';
use Models\Account;
use Carbon\Carbon;
validateLogin(true, false);//check account login
requirePerm("god");

$accountList = Account::get();

echo(json_encode($accountList));
?>