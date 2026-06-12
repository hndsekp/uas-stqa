<?php
include 'koneksi.php';

$id = $_GET['id'];

$delete = mysqli_query($koneksi, "
    DELETE FROM tb_mhs WHERE id='$id'
");

if ($delete) {

    echo "
    <script>
        alert('Data berhasil dihapus');
        window.location='dashboard.php';
    </script>
    ";

} else {

    echo "
    <script>
        alert('Data gagal dihapus');
        window.location='dashboard.php';
    </script>
    ";
}