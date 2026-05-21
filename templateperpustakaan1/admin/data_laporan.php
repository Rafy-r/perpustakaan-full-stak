<style>
    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<?php
require_once __DIR__ . '/../koneksi.php';
@mysqli_query($conn, "ALTER TABLE peminjaman ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'Belum dikembalikan'");

$query = mysqli_query($conn, "SELECT peminjaman.*, anggota.Nama_Anggota, buku.Judul_Buku FROM peminjaman INNER JOIN anggota ON anggota.Id_Anggota = peminjaman.Id_Anggota INNER JOIN buku ON buku.Id_Buku = peminjaman.Id_Buku");
$no = 1;
?>

<h1 class="mt-4">Tampil Laporan Perpustakaan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard / Tampil Laporan</li>
</ol>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabel Laporan Perpustakaan
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
                        <td colspan="5" class="text-center">Belum ada data laporan.</td>
                    </tr>
                <?php else : ?>
                    <?php while ($d = mysqli_fetch_assoc($query)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($d['Judul_Buku']); ?></td>
                            <td><?= htmlspecialchars($d['Nama_Anggota']); ?></td>
                            <td><?= htmlspecialchars($d['tgl_peminjaman']); ?></td>
                            <td><?= htmlspecialchars($d['status'] ?? 'Belum dikembalikan'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
               