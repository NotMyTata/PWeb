<?php

include("config.php");

if(!isset($_GET['id'])){
    header('Location: list-siswa.php');
}

$id = $_GET['id'];

$sql = "SELECT * FROM calon_siswa WHERE id = $id";
$query = mysqli_query($db, $sql);
$siswa = mysqli_fetch_assoc($query);

if(mysqli_num_rows($query) < 1){
    die("Data tidak ditemukan...");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body{
            height: 100%;
        }
    </style>
</head>
<body class="d-flex align-items-center p-4">
    <main class="form-daftar m-auto border rounded shadow px-5 py-2">
        <p class="h4 py-2">Formulir Perubahan Data Siswa</p>
        <form action="proses-edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $siswa['id'] ?>">
            <div class="form-group py-2">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?php echo $siswa['nama'] ?>" required>
            </div>
            <div class="form-group py-2">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea class="form-control" name="alamat" rows="3" required><?php echo $siswa['alamat'] ?></textarea>
            </div>
            <div class="form-group row py-2">
                <div class="form-group col-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                    <?php $jk = $siswa['jenis_kelamin']; ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo ($jk == 'Laki-laki')? "checked" : "" ?>>
                        <label class="form-check-label" for="jenis_kelamin">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" <?php echo ($jk == 'Perempuan')? "checked" : "" ?>>
                        <label class="form-check-label" for="jenis_kelamin">Perempuan</label>
                    </div>
                </div>
                <div class="form-group col-6">    
                    <label for="agama" class="form-label">Agama:</label>
                    <?php $agama = $siswa['agama'] ?>
                    <select name="agama" class="form-control">
                        <option value="Islam" <?php echo($agama == 'Islam')? "selected" : "" ?>>Islam</option>
                        <option value="Kristen" <?php echo($agama == 'Kristen')? "selected" : "" ?>>Kristen</option>
                        <option value="Hindu" <?php echo($agama == 'Hindu')? "selected" : "" ?>>Hindu</option>
                        <option value="Budha" <?php echo($agama == 'Budha')? "selected" : "" ?>>Budha</option>
                        <option value="Atheis" <?php echo($agama == 'Atheis')? "selected" : "" ?>>Atheis</option>
                    </select>
                </div>
            </div>
            <div class="form-group py-2">
                <label for="sekolah_asal" class="form-label">Sekolah Asal:</label>
                <input type="text" name="sekolah_asal" class="form-control" placeholder="Nama Sekolah" value="<?php echo $siswa['sekolah_asal'] ?>" required>
            </div>
            <div class="py-2">
            <input type="submit" class="btn btn-primary" value="Simpan" name="simpan">
            </div>
        </form>
    </main>
</body>
</html>
</html>