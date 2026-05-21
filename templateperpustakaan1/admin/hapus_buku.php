<?php
include '../koneksi.php';

/** @var mysqli $conn */
$id = $_GET['id'];

// Ambil data foto sebelum hapus
$query = mysqli_query($conn, "SELECT Foto FROM buku WHERE Id_Buku = '$id'");
$data = mysqli_fetch_assoc($query);

// Hapus foto dari folder jika ada
if (!empty($data['Foto']) && file_exists("../images/admin/cover/" . $data['Foto'])) {
    unlink("../images/admin/cover/" . $data['Foto']);
}

// Hapus data dari database
$hapus = mysqli_query($conn, "DELETE FROM buku WHERE Id_Buku = '$id'");

if ($hapus) {

    echo "
    <script>
        alert('Data berhasil dihapus');
        window.location.href='index.php?page=data_buku';
    </script>";

} else {

    echo "
    <script>
        alert('Gagal menghapus data: " . mysqli_error($conn) . "');
        window.location.href='index.php?page=data_buku';
    </script>";
}
?>
