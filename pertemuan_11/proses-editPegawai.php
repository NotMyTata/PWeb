<?php

include("config.php");

if(isset($_POST['perbaru'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];

    $sql = "UPDATE pegawai SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', email='$email', telp='$telp' WHERE id = $id";
    $query = mysqli_query($db, $sql);

    if($query){
        header('Location: list-pegawai.php');
    } else {
        die("Gagal menyimpan perubahan...");
    }
} else {
    die("Akses dilarang...");
}

?>