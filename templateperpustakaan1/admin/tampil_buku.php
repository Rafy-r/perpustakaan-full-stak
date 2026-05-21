<?php
require_once __DIR__ . '/../koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM buku ORDER BY Id_Buku ASC") or die(mysqli_error($conn));
$no = 1;
?>

<h1 class="mt-4 ms-5 me-3">Data Buku</h1>
<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Tampilkan Data Buku</span>
</div>
<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabel Data Buku Perpustakaan
    </div>
    <div class="card-body">
        <a href="index.php?page=tambah_buku" class="btn btn-primary mb-3">
            <i class="fas fa-plus me-1"></i> Tambah Buku
        </a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>

                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>

                    <td><?= $data['Judul_Buku']; ?></td>
                    <td><?= $data['Pengarang']; ?></td>
                    <td><?= $data['Penerbit']; ?></td>
                    <td><?= $data['Tahun_Terbit']; ?></td>
                    <td>
                        <?php if (!empty($data['Foto'])) : ?>
                            <img src="../images/admin/cover/<?= $data['Foto']; ?>" alt="Cover" width="60">
                        <?php else : ?>
                            <span class="text-muted">Tidak ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="index.php?page=edit_buku&id=<?= $data['Id_Buku']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="index.php?page=hapus_buku&id=<?= $data['Id_Buku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
