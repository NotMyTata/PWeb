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
        <p class="h4 py-2">Formulir Pendaftaran Siswa Baru</p>
        <form action="proses-pendaftaran.php" method="POST">
            <div class="form-group py-2">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div class="form-group py-2">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea class="form-control" name="alamat" rows="3" required></textarea>
            </div>
            <div class="form-group row py-2">
                <div class="form-group col-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" checked>
                        <label class="form-check-label" for="jenis_kelamin">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan">
                        <label class="form-check-label" for="jenis_kelamin">Perempuan</label>
                    </div>
                </div>
                <div class="form-group col-6">    
                    <label for="agama" class="form-label">Agama:</label>
                    <select name="agama" class="form-control">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Atheis">Atheis</option>
                    </select>
                </div>
            </div>
            <div class="form-group py-2">
                <label for="sekolah_asal" class="form-label">Sekolah Asal:</label>
                <input type="text" name="sekolah_asal" class="form-control" placeholder="Nama Sekolah" required>
            </div>
            <div class="py-2">
            <input type="submit" class="btn btn-primary" value="Daftar" name="daftar">
            </div>
        </form>
    </main>
</body>
</html>