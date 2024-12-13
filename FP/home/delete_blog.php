<?php
include('../config.php');
$id = $_GET['id'];

$sql = "DELETE FROM blog WHERE id = '$id'";
$result = mysqli_query($db, $sql);

if($result){
    header('Location: home_page.php?status=success');
} else {
    header('Location: home_page.php?status=failed');
}

?>