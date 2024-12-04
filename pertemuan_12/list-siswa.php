<?php include("config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Siswa Terdaftar</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>
<body class="p-4">
    <header>
        <p class="h2">Siswa Terdaftar</p>
    </header>
    <nav>
        <a href="form-daftar.php">[+] Tambah Baru</a>
    </nav>
    <table class="table table-striped">
        <thead>
            <tr>
                <td scope="col">ID</td>
                <td scope="col">Nama</td>
                <td scope="col">Alamat</td>
                <td scope="col">Jenis Kelamin</td>
                <td scope="col">Agama</td>
                <td scope="col">Sekolah Asal</td>
                <td scope="col">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM calon_siswa";
            $query = mysqli_query($db, $sql);

            while($siswa = mysqli_fetch_array($query)){
                echo "<tr>";

                echo "<td>".$siswa['id']."</td>";
                echo "<td>".$siswa['nama']."</td>";
                echo "<td>".$siswa['alamat']."</td>";
                echo "<td>".$siswa['jenis_kelamin']."</td>";
                echo "<td>".$siswa['agama']."</td>";
                echo "<td>".$siswa['sekolah_asal']."</td>";

                echo "<td>";
                echo "<a href='form-edit.php?id=".$siswa['id']."'>Edit</a> | ";
                echo "<a href='hapus.php?id=".$siswa['id']."'>Hapus</a>";
                echo "</td>";

                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
    <p>Total Siswa: <?php echo mysqli_num_rows($query) ?></p>
</body>
</html>