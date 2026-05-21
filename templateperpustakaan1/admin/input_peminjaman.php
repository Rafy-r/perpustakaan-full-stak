<?php
require_once __DIR__ . '/../koneksi.php';

$query_1 = "SELECT * FROM anggota";
$result_1 = mysqli_query($conn, $query_1);
$query_2 = "SELECT * FROM buku";
$result_2 = mysqli_query($conn, $query_2);

$query_peminjaman = mysqli_query($conn, "SELECT peminjaman.*, anggota.nama_anggota, buku.Judul_Buku FROM peminjaman JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota JOIN buku ON peminjaman.id_buku = buku.id_buku");

if (!isset($conn)) {
    die('Koneksi database gagal. Pastikan file koneksi.php terhubung.');
}

$anggota = mysqli_query($conn, "SELECT * FROM anggota");
$buku = mysqli_query($conn, "SELECT * FROM buku");

if ($server = $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];

    $insert_query = "INSERT INTO peminjaman (id_anggota, id_buku, tgl_peminjaman) VALUES ('$id_anggota', '$id_buku', '$tgl_peminjaman')";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {

        echo "
        <script>
            alert('Data peminjaman berhasil ditambahkan!');
            window.location='index.php?page=data_peminjaman ';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data gagal ditambahkan!');
        </script>
        ";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Peminjaman</title>

    <link href="../assets/css/styles.css" rel="stylesheet" />

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">Input Data Peminjaman</h1>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Nama Anggota</label>

            <select name="id_anggota" class="form-control" required>
                <option value="">-- Pilih Anggota --</option>

                <?php while($data_anggota = mysqli_fetch_assoc($anggota)) { ?>

                    <option value="<?= $data_anggota['id_anggota']; ?>">
                        <?= $data_anggota['nama_anggota']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Judul Buku</label>

            <select name="id_buku" class="form-control" required>
                <option value="">-- Pilih Buku --</option>

                <?php while($data_buku = mysqli_fetch_assoc($buku)) { ?>

                    <option value="<?= $data_buku['id_buku']; ?>">
                        <?= $data_buku['Judul_Buku']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tgl_peminjaman" class="form-control" required>
        </div>

        <!-- Tombol -->
        <button type="submit" name="simpan" class="btn btn-primary">
            Simpan
        </button>

        <a href="data_peminjaman.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>