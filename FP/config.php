<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "lovestoblog";

$db = mysqli_connect($hostname,$username,$password, $database);

if(mysqli_connect_errno()){
    echo "Failed to connect to DB";
}

?>