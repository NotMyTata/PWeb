<?php
session_start();
include('../config.php');
$user_id = $_SESSION['current_id'];
$blog_id = $_GET['id'];

$sql = "SELECT * FROM blog WHERE id = '$blog_id' AND author_id = '$user_id'";
$result = mysqli_query($db, $sql);
$blog = mysqli_fetch_array($result);

if(mysqli_num_rows($result) > 0){
    $thumbnail = $blog['thumbnail'];
    $target_file = "../images/thumbnail/user_blog/$user_id/".$thumbnail;

    if(file_exists($target_file)){
        unlink($target_file);
    }

    $sql = "DELETE FROM blog WHERE id = '$blog_id'";
    $result = mysqli_query($db, $sql);

    if($result){
        header('Location: home_page.php?status=success');
    } else {
        header('Location: home_page.php?status=failed');
    }
}

?>