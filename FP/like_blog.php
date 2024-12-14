<?php
session_start();
include("config.php");

$blog_id = $_GET['id'];
$user_id = $_SESSION['current_id'];

$sql = "SELECT * FROM liked_blog WHERE user_id = '$user_id' AND blog_id ='$blog_id'";
$result = mysqli_query($db, $sql);

if($_GET['type'] == 1){
    if(mysqli_num_rows($result) > 0){
        header('Location: blog_page.php?id='.$blog_id.'?status=failed');
    }
    
    $sql = "INSERT INTO liked_blog VALUES ('$user_id', '$blog_id')";
    $result = mysqli_query($db, $sql);
    
    if($result){
        header('Location: blog_page.php?id='.$blog_id.'?status=success');
    } else {
        header('Location: blog_page.php?id='.$blog_id.'?status=failed');
    }
} else {
    if(mysqli_num_rows($result) == 0){
        header('Location: blog_page.php?id='.$blog_id.'?status=failed');
    }
    
    $sql = "DELETE FROM liked_blog WHERE user_id ='$user_id' AND blog_id = '$blog_id'";
    $result = mysqli_query($db, $sql);
    
    if($result){
        header('Location: blog_page.php?id='.$blog_id.'?status=success');
    } else {
        header('Location: blog_page.php?id='.$blog_id.'?status=failed');
    }
}

?>