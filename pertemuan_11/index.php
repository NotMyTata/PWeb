<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body{
            height: 100%;
        }
        html *{
            text-align: center;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center">
    <main class="m-auto p-4 rounded shadow">
        <p class="h5">Pendaftaran Siswa Baru</p>
        <p class="h1">SMK Cerdas</p>
        <div class="py-2">
            <a href="form-daftar.php" class="btn btn-primary">Daftar Sekarang</a>
            <a href="list-siswa.php" class="btn btn-outline-primary">List Pendaftar</a>
        </div>
        <?php if(isset($_GET['status'])): ?>
        <p>
            <?php
                if($_GET['status'] == 'sukses'){
                    echo "Pendaftaran siswa baru berhasil!";
                } else {
                    echo "Pendaftaran gagal!";
                }
            ?>
        </p>
        <?php endif; ?>
    </main>
    <div class="py-2 position-fixed fixed-bottom">
        <p class="h6">Butuh Bantuan?</p>
        <a href="list-pegawai.php" class="btn btn-secondary">Hubungi Kami</a>
    </div>
</body>
</html>