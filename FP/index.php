<?php

session_start();

if(!isset($_SESSION['current_id'])){
    header('Location: login/login_page.html');
} else {
    header('Location: home/home_page.php');
}

?>