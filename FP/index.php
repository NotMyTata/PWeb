<?php

session_start();

if(!isset($_SESSION['current_id'])){
    header('Location: FP/login/login_page.html');
} else {
    header('Location: FP/home/home_page.php');
}

?>