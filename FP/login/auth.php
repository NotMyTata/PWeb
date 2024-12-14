<?php
session_start();
include('../config.php');

if(isset($_POST['login'])){
    
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $remember = $_POST['remember'] == 'remember'? 1 : 0;

    
    $sql = "SELECT * FROM blogger WHERE username = '$username' AND pass = '$pass' LIMIT 1";
    $result = mysqli_query($db, $sql);
    

    if(mysqli_num_rows($result) < 1){
        header('Location: login_page.html?status=failed');
    } else {
        $blogger = mysqli_fetch_assoc($result);
        $_SESSION['current_id'] = $blogger['id'];
        header('Location: ../home/home_page.php');
    }

} else if(isset($_POST['signup'])){
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];
    
    if($pass != $repass){
        header('Location login_page.html?status=failed');
    }

    $sql = "SELECT * FROM blogger WHERE username = '$username'";
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) >= 1){
        die("Blogger with the same username already exists");
    }

    $sql = "INSERT INTO blogger VALUES (NULL, '$username', '$email', '$pass')";
    $result = mysqli_query($db, $sql);

    if($result){
        header('Location: login_page.html?status=success');
    } else {
        header('Location: login_page.html?status=failed');
    }

}

?>