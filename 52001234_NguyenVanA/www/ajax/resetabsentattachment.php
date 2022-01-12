<?php
session_start();
if(!empty($_SESSION['absenttmpfiles'])){
    if (!$_SESSION['acceptabsenttmpfiles'] ) {
        foreach($_SESSION['absenttmpfiles'] as $value) {
            unlink('../'.$value);
        }
    }
    $_SESSION['absenttmpfiles'] = null;
}
?>