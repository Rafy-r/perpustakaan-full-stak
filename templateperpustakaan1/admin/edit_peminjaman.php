<?php
require_once __DIR__ . '/../koneksi.php';

if (!isset($conn)) {
    die('Koneksi database gagal. Pastikan file koneksi.php terhubung.');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID peminjaman tidak ditemukan.');
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "SELECT peminjaman.*, anggota.Nama_Anggota, buku.Judul_Buku FROM peminjaman JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota JOIN buku ON peminjaman.id_buku = buku.id_buku WHERE peminjaman.id_peminjaman = '$id'");

if (!$query) {
    die('Query error: ' . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die('Data peminjaman tidak ditemukan.');
}

$anggota = mysqli_query($conn, "SELECT * FROM anggota");
$buku = mysqli_query($conn, "SELECT * FROM buku");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = mysqli_real_escape_string($conn, $_POST['id_anggota']);
    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $tgl_peminjaman = mysqli_real_escape_string($conn, $_POST['tgl_peminjaman']);

    $update = mysqli_query($conn, "UPDATE peminjaman SET id_anggota = '$id_anggota', id_buku = '$id_buku', tgl_peminjaman = '$tgl_peminjaman' WHERE id_peminjaman = '$id'");

    if ($update) {
        echo "<script>
            alert('Data peminjaman berhasil diubah');
            window.location.href = 'index.php?page=data_peminjaman';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Gagal mengubah data: " . addslashes(mysqli_error($conn)) . "');
        </script>";
    }
}
?>

<h1 class="mt-4 ms-5 me-3">Edit Data Peminjaman</h1>

<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Edit Data Peminjaman</span>
</div>

<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Form Edit Data Peminjaman
    </div>

    <div class="card-body">
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Nama Anggota</label>
                <select name="id_anggota" class="form-control" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php while ($data_anggota = mysqli_fetch_assoc($anggota)) : ?>
                        <option value="<?= $data_anggota['id_anggota']; ?>" <?= $data_anggota['id_anggota'] == $data['id_anggota'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($data_anggota['nama_anggota']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <select name="id_buku" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php while ($data_buku = mysqli_fetch_assoc($buku)) : ?>
                        <option value="<?= $data_buku['id_buku']; ?>" <?= $data_buku['id_buku'] == $data['id_buku'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($data_buku['Judul_Buku']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tgl_peminjaman" class="form-control" value="<?= htmlspecialchars($data['tgl_peminjaman']); ?>" required>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php?page=data_peminjaman" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
