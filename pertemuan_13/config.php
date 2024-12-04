<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "pweb13";

$db = mysqli_connect($hostname, $username, $password, $database);

if (mysqli_connect_errno()) {
    printf("Database failed to connect", mysqli_connect_error());
};

?>