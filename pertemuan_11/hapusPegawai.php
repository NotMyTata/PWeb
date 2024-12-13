<?php

include("config.php");

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM pegawai WHERE id = $id";
    $query = mysqli_query($db, $sql);

    if($query){
        header('Location: list-pegawai.php');
    } else {
        die("Gagal menghapus");
    }

} else {
    die("Akses dilarang...");
}

?>