<?php
include '../koneksi.php';

/** @var mysqli $conn */
$id = $_GET['id'];
$hapus = mysqli_query($conn, "DELETE FROM peminjaman WHERE Id_Peminjaman = '$id'");

if ($hapus) {
    echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = 'index.php?page=data_peminjaman';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data: " . mysqli_error($conn) . "');
        window.location.href = 'index.php?page=data_peminjaman';
    </script>";
}
?>