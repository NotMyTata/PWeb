<?php
session_start();

include('../config.php');

if(isset($_POST['create'])){
    $user_id = $_SESSION['current_id'];
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $content = mysqli_real_escape_string($db, $_POST['content']);
    $date = date('Y-m-d');
    $author_id = $_SESSION['current_id'];
    $views = 0;
    $thumbnail = basename($_FILES['thumbnail']['name']);
    $tag = $_POST['tag'];
    $publish = $_POST['publish'] == "publish"? 1 : 0;

    $target_dir = "../images/thumbnail/user_blog/$user_id/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 777, true);
    }
    $target_file = $target_dir . $thumbnail;
    $uploadOk = 1;
    $result = 0;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    // Check file size bigger than 5MB
    if ($_FILES["thumbnail"]["size"] > 5*1000*1000) {
        $uploadOk = 0;
    }
    // Check if all good
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO blog VALUES (NULL, '$title', '$author_id', '$date', '$views', '$thumbnail', '$tag', '$content', '$publish')";
            $result = mysqli_query($db, $sql);

            $sql = "SELECT id FROM blog ORDER BY id DESC LIMIT 1";
            $result = mysqli_query($db, $sql);
            $new_blog = mysqli_fetch_array($result);
            $new_id = $new_blog["id"];
            $imageFileType = strtolower(pathinfo($target_dir . $thumbnail,PATHINFO_EXTENSION));
            $new_file = $new_id . ".". $imageFileType;
            $new_file_dir = $target_dir . $new_file;
            rename($target_file, $new_file_dir);

            $sql = "UPDATE blog SET thumbnail = '$new_file' WHERE id = '$new_id'";
            $result = mysqli_query($db, $sql);
        }
    }

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
        $sql = "SELECT * FROM blog WHERE id = '$blog_id' AND author_id = '$user_id'";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) == 0){
            header('Location: home_page.php?stasus=failed');
        }
        $blog = mysqli_fetch_array($result);

        $title = mysqli_real_escape_string($db, $_POST['title']);
        $content = mysqli_real_escape_string($db,  $_POST['content']);
        $thumbnail = basename($_FILES['thumbnail']['name']);
        $tag = $_POST['tag'];
        $publish = $_POST['publish'] == "publish"? 1 : 0;
        
        $result = 0;

        // If the user didn't upload a new thumbnail
        if($thumbnail == ""){
            $sql = "UPDATE blog SET title = '$title', tag = '$tag', content = '$content', published = '$publish' WHERE id = '$blog_id'";
            $result = mysqli_query($db, $sql);
        } else {
            $target_dir = "../images/thumbnail/user_blog/$user_id/";
            $old_thumbnail = $blog['thumbnail'];
            $old_file_dir = $target_dir . $old_thumbnail;
            $imageFileType = strtolower(pathinfo($target_dir . $thumbnail,PATHINFO_EXTENSION));
            $new_file = $blog_id . ".". $imageFileType;
            $new_file_dir = $target_dir . $new_file;
            $uploadOk = 1;

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            } 
            // Check if file already exists
            if (file_exists($old_file_dir)) {
                unlink($old_file_dir);
            } else if (!file_exists($target_dir)){
                mkdir($target_dir,777, true);
            }
            // Check file size bigger than 5MB
            if ($_FILES["thumbnail"]["size"] > 5*1000*1000) {
                $uploadOk = 0;
            }
            // Check if all good
            if ($uploadOk) {
                if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $new_file_dir)) {
                    $sql = "UPDATE blog SET title = '$title', thumbnail = '$new_file', tag = '$tag', content = '$content', published = '$publish' WHERE id = '$blog_id'";
                    $result = mysqli_query($db, $sql);
                }
            }
        }
    
        if($result){
            header('Location: home_page.php?status=success');
        } else {
            header('Location: home_page.php?status=failed');
        }
    }
}

?>