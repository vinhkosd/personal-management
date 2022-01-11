<?php
session_start();
if(!empty($_SESSION['tmpfiles'])){
    if (!$_SESSION['accepttmpfiles'] ) {
        foreach($_SESSION['tmpfiles'] as $value) {
            unlink('../'.$value);
        }
    }
    $_SESSION['tmpfiles'] = null;
}
?>