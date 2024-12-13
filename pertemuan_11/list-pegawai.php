<?php include("config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Pegawai</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>
<body class="p-4">
    <header>
        <p class="h2">Kontak Pegawai</p>
    </header>
    <nav>
        <a href="form-addPegawai.php">[+] Tambah Pegawai</a>
    </nav>
    <table class="table table-striped">
        <thead>
            <tr>
                <td scope="col">ID</td>
                <td scope="col">Nama</td>
                <td scope="col">Email</td>
                <td scope="col">Telp</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM pegawai";
            $query = mysqli_query($db, $sql);

            while($pegawai = mysqli_fetch_array($query)){
                echo "<tr>";

                echo "<td>".$pegawai['id']."</td>";
                echo "<td>".$pegawai['nama']."</td>";
                echo "<td>".$pegawai['email']."</td>";
                echo "<td>".$pegawai['telp']."</td>";
                echo "<td>";
                echo "<a href='form-editPegawai.php?id=".$pegawai['id']."'>Edit</a> | ";
                echo "<a href='hapusPegawai.php?id=".$pegawai['id']."'>Hapus</a>";
                echo "</td>";

                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
</body>
</html>