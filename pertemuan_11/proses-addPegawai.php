<?php

include("config.php");

if(isset($_POST['tambah'])){
    
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $notelp = $_POST['notelp'];

    $sql = "INSERT INTO pegawai VALUES (null, '$nama', '$alamat', '$jk', '$email', '$notelp')";
    $query = mysqli_query($db, $sql);

    if($query){
        header('Location: list-pegawai.php?status=sukses');
    } else {
        header('Location: list-pegawai.php?status=gagal');
    }
} else {
    die("Akses dilarang...");
}

?>