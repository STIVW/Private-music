<?php
$target_dir = "/var/www/html/private-music/uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// 检查是否是一个音乐文件
if($fileType != "mp3" && $fileType != "ogg" && $fileType != "wav") {
    echo "只允许上传MP3、OGG或WAV格式的音乐文件。";
    $uploadOk = 0;
}
// 检查文件是否已经存在
if (file_exists($target_file)) {
    echo "该文件已经存在。";
    $uploadOk = 0;
}
// 检查文件大小
if ($_FILES["file"]["size"] > 5000000) {
    echo "文件太大，不能上传超过5MB的文件。";
    $uploadOk = 0;
}
// 如果存在错误，停止上传
if ($uploadOk == 0) {
    echo "文件没有上传。";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "文件". basename( $_FILES["file"]["name"]). "上传成功。";
    } else {
        echo "上传文件时出现了错误。";
    }
}
?>
