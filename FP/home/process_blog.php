<?php
session_start();

include('../config.php');

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $date = date('Y-m-d');
    $author_id = $_SESSION['current_id'];
    $views = 0;
    $thumbnail = $_POST['thumbnail'];
    $tag = $_POST['tag'];
    $content = $_POST['content'];
    $publish = $_POST['publish'];
    
    $sql = "INSERT INTO blog VALUES (NULL, '$title', '$author_id', '$date', '$views', '$thumbnail', '$tag', '$content', '$publish')";
    $result = mysqli_query($db, $sql);

    if($result){
        header('Location: home_page.php?status=success');
    } else {
        header('Location: home_page.php?status=failed');
    }
}

?>