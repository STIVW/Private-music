<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["music_file"]["name"]);
$uploadOk = 1;
$audioFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is a valid audio file
if(isset($_POST["submit"])) {
    $check = getID3($target_file);
    if($check["fileformat"] !== "mp3" && $check["fileformat"] !== "ogg" && $check["fileformat"] !== "wav") {
        $uploadOk = 0;
        $response = array(
            "success" => false,
            "message" => "文件格式不支持"
        );
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $uploadOk = 0;
    $response = array(
        "success" => false,
        "message" => "文件已存在"
    );
}

// Check file size
if ($_FILES["music_file"]["size"] > 50000000) {
    $uploadOk = 0;
    $response = array(
        "success" => false,
        "message" => "文件过大"
    );
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $response = array(
        "success" => false,
        "message" => "上传失败"
    );
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["music_file"]["tmp_name"], $target_file)) {
        // File upload success
        $response = array(
            "success" => true,
            "message" => "文件上传成功"
        );
        
        // Add new track to playlist
        $filename = basename($target_file);
        $newTrack = array(
            "name" => "New Song",
            "artist" => "Unknown",
            "file" => "uploads/" . $filename
        );
        array_push($playlist, $newTrack);
        
    } else {
        // File upload failed
        $response = array(
            "success" => false,
            "message" => "上传失败"
        );
    }
}
echo json_encode($response);
?>
