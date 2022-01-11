<?php
include __DIR__.'/../app/index.php';
use Models\PhongBan;
use Carbon\Carbon;
validateLogin(true, false);//check account login

$phongBanQuery = PhongBan::query();

$phongBanList = $phongBanQuery->get(["id", "ten"]);

echo(json_encode($phongBanList));
?>