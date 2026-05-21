<?php
require_once __DIR__ . '/../koneksi.php';

/** Pastikan kolom status tersedia untuk fitur kembali */
@mysqli_query($conn, "ALTER TABLE peminjaman ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'Belum dikembalikan'");

$query = mysqli_query($conn, "SELECT peminjaman.*, peminjaman.Id_Peminjaman AS id_peminjaman, anggota.Nama_Anggota, buku.Judul_Buku, peminjaman.status FROM peminjaman INNER JOIN anggota ON anggota.Id_Anggota = peminjaman.Id_Anggota INNER JOIN buku ON buku.Id_Buku = peminjaman.Id_Buku");
$no = 1;
?>

<h1 class="mt-4 ms-5 me-3">Data Peminjaman</h1>
<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Tampilkan Data Peminjaman</span>
</div>
<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabel Data Peminjaman
    </div>
    <div class="card-body">
        <a href="index.php?page=input_peminjaman" class="btn btn-primary mb-3">
            <i class="fas fa-plus me-1"></i> Tambah Peminjaman
        </a>
        <a href="index.php?page=kembali" class="btn btn-success mb-3 ms-2">
            <i class="fas fa-undo me-1"></i> Lihat Buku Dikembalikan
        </a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Nama Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['Judul_Buku']; ?></td>
                    <td><?= $data['Nama_Anggota']; ?></td>
                    <td><?= $data['tgl_peminjaman']; ?></td>
                    <td>
                        <?= htmlspecialchars($data['status'] ?: 'Belum dikembalikan'); ?>
                    </td>
                    <td>
                        <a href="index.php?page=edit_peminjaman&id=<?= $data['id_peminjaman']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if ($data['status'] !== 'Sudah dikembalikan') : ?>
                        <a href="index.php?page=kembali&action=return&id=<?= $data['id_peminjaman']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi: Buku ini sudah dikembalikan?')"><i class="fas fa-undo"></i> Kembalikan
                        </a>
                        <?php else: ?>
                        <span class="badge bg-success">Sudah dikembalikan</span>
                        <?php endif; ?>
                        <a href="index.php?page=hapus_peminjaman&id=<?= $data['id_peminjaman']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
