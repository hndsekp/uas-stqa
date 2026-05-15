<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $fakultas = $_POST['fakultas'];

    $insert = mysqli_query($koneksi, "
        INSERT INTO tb_mhs (nama, nim, fakultas)
        VALUES ('$nama', '$nim', '$fakultas')
    ");

    if ($insert) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            window.location='dashboard.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f1b2d;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
        }

        .container {
            width: 420px;
            background: #1a2d4a;
            border-radius: 18px;
            padding: 32px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        h2 {
            margin-bottom: 24px;
            text-align: center;
        }

        input {
            width: 94%;
            padding: 13px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: white;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #3b82f6;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #2563eb;
        }

        a {
            display: inline-block;
            margin-top: 18px;
            color: #94a3b8;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>Tambah Data Mahasiswa</h2>

        <form method="POST">

            <input type="text" name="nama" placeholder="Nama">

            <input type="text" name="nim" placeholder="NIM">

            <input type="text" name="fakultas" placeholder="Fakultas">

            <button type="submit" name="submit">
                Simpan Data
            </button>

        </form>

        <a href="dashboard.php?tab=crud">← Kembali</a>
    </div>

</body>

</html>