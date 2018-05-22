<?php
header("Content-Type: text/html; charset=utf-8");
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png", 'txt');
$temp = explode(".", $_FILES["file"]["name"]);
echo $_FILES["file"]["size"];
$extension = end($temp);     // 获取文件后缀名
if ($_FILES["file"]["size"] < 204800) {
    if ($_FILES["file"]["error"] > 0) {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    } else {
        echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
        echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
        echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";

        // 判断当期目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        $path = "upload/" . $_FILES["file"]["name"];
        if (file_exists($path)) {
            unlink("upload/" . $_FILES["file"]["name"]);
        }
        // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
        if (!file_exists("upload")) {
            mkdir("upload/");
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
        echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
    }
} else {
    echo "非法的文件格式";
}
?>