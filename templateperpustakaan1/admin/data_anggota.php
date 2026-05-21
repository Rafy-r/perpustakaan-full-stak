<?php
include '../koneksi.php';
$id = $_GET['id'];

/** @var mysqli $conn */
$id = $_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM anggota WHERE Id_Anggota = '$id'");

if ($hapus) {
    echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = 'index.php?page=data_anggota';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data: " . mysqli_error($conn) . "');
        window.location.href = 'index.php?page=data_anggota';
    </script>";
}
?>