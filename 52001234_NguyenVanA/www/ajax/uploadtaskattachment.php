<?php
session_start();
$target_dir = "../uploads/";
$target_file = $target_dir . "-" . time() . "-" . basename($_FILES["file"]["name"]);
$fileName = "uploads/". "-" . time() . "-" . basename($_FILES["file"]["name"]);
$_SESSION['tmpfiles'] = !empty($_SESSION['tmpfiles']) ? $_SESSION['tmpfiles'] : [];
$_SESSION['accepttmpfiles'] = false;
if (isset($_FILES["file"]) && !empty($_FILES["file"]) && !empty($_FILES["file"]["tmp_name"])) {
    if($_FILES['file']['size'] > 5 * 1024 * 1024) {
        http_response_code(500);
        echo('Kích thước file vượt quá 5mb!');
       
        die();
    }

    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(($fileType == "jpg" || $fileType == "png" || $fileType == "jpeg" || $fileType == "gif"|| $fileType == "doc"|| $fileType == "docx"|| $fileType == "txt")) {
        $uploadOk = true;
    } else {
        $uploadOk = false;
    }

    if($uploadOk) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            array_push($_SESSION['tmpfiles'], $fileName);
        }
    } else {
        http_response_code(500);
        echo('Tệp tải lên có định dạng không hợp lệ (yêu cầu: tệp ảnh có định dạng .png, .jpeg, .jpg, .gif, .docx, .doc, .txt).');
        die();
    }
    
}