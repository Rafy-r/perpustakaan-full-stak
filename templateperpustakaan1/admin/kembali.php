<?php
require_once __DIR__ . '/../koneksi.php';


@mysqli_query($conn, "ALTER TABLE peminjaman ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'Belum dikembalikan'");

if (isset($_GET['action']) && $_GET['action'] === 'return' && isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $update = mysqli_query($conn, "UPDATE peminjaman SET status = 'Sudah dikembalikan' WHERE Id_Peminjaman = '$id' OR id_peminjaman = '$id'");

    if ($update) {
        echo "<script>alert('Buku sudah dikembalikan'); window.location.href='index.php?page=kembali';</script>";
        exit;
    }

    echo "<script>alert('Gagal mengubah status: " . addslashes(mysqli_error($conn)) . "'); window.location.href='index.php?page=data_peminjaman';</script>";
    exit;
}

$query = mysqli_query($conn, "SELECT peminjaman.*, peminjaman.Id_Peminjaman AS id_peminjaman, anggota.Nama_Anggota, buku.Judul_Buku FROM peminjaman INNER JOIN anggota ON anggota.Id_Anggota = peminjaman.Id_Anggota INNER JOIN buku ON buku.Id_Buku = peminjaman.Id_Buku WHERE peminjaman.status = 'Sudah dikembalikan'");
?>

<h1 class="mt-4 ms-5 me-3">Buku Dikembalikan</h1>
<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Buku Dikembalikan</span>
</div>
<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabel Buku Dikembalikan
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="index.php?page=data_peminjaman" class="btn btn-primary no-print">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Data Peminjaman
            </a>
            <button type="button" class="btn btn-success no-print ms-2" onclick="window.print();">
                <i class="fas fa-print me-1"></i> Cetak Laporan
            </button>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Nama Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($query) === 0) : ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada buku yang dikembalikan.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($data['Judul_Buku']); ?></td>
                            <td><?= htmlspecialchars($data['Nama_Anggota']); ?></td>
                            <td><?= htmlspecialchars($data['tgl_peminjaman']); ?></td>
                            <td><?= htmlspecialchars($data['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

