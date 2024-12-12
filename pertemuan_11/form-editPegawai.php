<?php

include("config.php");

if(!isset($_GET['id'])){
    header('Location: list-pegawai.php');
}

$id = $_GET['id'];

$sql = "SELECT * FROM pegawai WHERE id = $id";
$query = mysqli_query($db, $sql);
$pegawai = mysqli_fetch_assoc($query);

if(mysqli_num_rows($query) < 1){
    die("Data tidak ditemukan...");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Perbaruan</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body{
            height: 100%;
        }
    </style>
</head>
<body class="d-flex align-items-center p-4">
    <main class="form-daftar m-auto border rounded shadow px-5 py-2">
        <p class="h4 py-2">Formulir Perubahan Pegawai</p>
        <form action="proses-editPegawai.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $pegawai['id'] ?>">
            <div class="form-group py-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?php echo $pegawai['nama']?>" required>
            </div>
            <div class="form-group py-2">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="3"required><?php echo $pegawai['alamat']?></textarea>
            </div>
            <div class="form-group row py-2">
                <div class="form-group col-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <?php $jk = $pegawai['jenis_kelamin']?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo ($jk == 'Laki-laki')? "checked" : "" ?>>
                        <label class="form-check-label" for="jenis_kelamin">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" <?php echo ($jk == 'Perempuan')? "checked" : "" ?>>
                        <label class="form-check-label" for="jenis_kelamin">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="form-group py-2">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="your_email@example.com" value="<?php echo $pegawai['email']?>" required>
            </div>
            <div class="form-group py-2">
                <label for="telp" class="form-label">Nomor Telepon</label>
                <input type="text" name="telp" class="form-control" value="<?php echo $pegawai['telp']?>" required>
            </div>
            <div class="py-2">
            <input type="submit" class="btn btn-primary" value="Perbaru" name="perbaru">
            </div>
        </form>
    </main>
</body>
</html>