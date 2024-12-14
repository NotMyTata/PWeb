<?php
session_start();

include('../config.php');

if(isset($_POST['create'])){
    $title = $_POST['title'];
    $date = date('Y-m-d');
    $author_id = $_SESSION['current_id'];
    $views = 0;
    $thumbnail = $_POST['thumbnail'];
    $tag = $_POST['tag'];
    $content = $_POST['content'];
    $publish = $_POST['publish'] == "publish"? 1 : 0;

    $title = mysqli_real_escape_string($db, $title);
    $content = mysqli_real_escape_string($db, $content);

    $sql = "INSERT INTO blog VALUES (NULL, '$title', '$author_id', '$date', '$views', '$thumbnail', '$tag', '$content', '$publish')";
    $result = mysqli_query($db, $sql);

    if($result){
        header('Location: home_page.php?status=success');
    } else {
        header('Location: home_page.php?status=failed');
    }
} else if(isset($_POST['edit'])){
    $user_id = $_SESSION['current_id'];
    $blog_id = $_POST['id'];
    $sql = "SELECT * FROM blog WHERE id = '$blog_id' AND author_id = '$user_id'";
    $result = mysqli_query($db, $sql);
    // Check if this blog is the current user's
    if(mysqli_num_rows($result) < 1){
        header('Location : home_page.php?staus=failed');
    } else {
        $title = $_POST['title'];
        $thumbnail = $_POST['thumbnail'];
        $tag = $_POST['tag'];
        $content = $_POST['content'];
        $publish = $_POST['publish'] == "publish"? 1 : 0;
        
        // If the user didn't upload a new thumbnail
        if($thumbnail == ""){
            $sql = "UPDATE blog SET title = '$title', tag = '$tag', content = '$content', published = '$publish' WHERE id = '$blog_id'";
        } else {
            $sql = "UPDATE blog SET title = '$title', thumbnail = '$thumbnail', tag = '$tag', content = '$content', published = '$publish' WHERE id = '$blog_id'";
        }
        $result = mysqli_query($db, $sql);
    
        if($result){
            header('Location: home_page.php?status=success');
        } else {
            header('Location: home_page.php?status=failed');
        }
    }
}

?>