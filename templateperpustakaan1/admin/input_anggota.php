<?php
include '../koneksi.php';

/** @var mysqli $conn */
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM anggota WHERE Id_Anggota = '$id'");
$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_anggota = $_POST['nama_anggota'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!empty($password)) {
        $update = mysqli_query($conn, "
            UPDATE anggota SET 
                Nama_Anggota = '$nama_anggota', 
                Alamat = '$alamat', 
                Jenis_Kelamin = '$jenis_kelamin', 
                Email = '$email', 
                Password = '$password' 
            WHERE Id_Anggota = '$id'
        ");
    } else {
        $update = mysqli_query($conn, "
            UPDATE anggota SET 
                Nama_Anggota = '$nama_anggota', 
                Alamat = '$alamat', 
                Jenis_Kelamin = '$jenis_kelamin', 
                Email = '$email' 
            WHERE Id_Anggota = '$id'
        ");
    }

    if ($update) {
        echo "<script>
            alert('Data berhasil diubah');
            window.location.href = 'index.php?page=data_anggota';
        </script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengubah data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<h1 class="mt-4 ms-5 me-3">Edit Data Anggota</h1>
<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Edit Data Anggota</span>
</div>
<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Form Edit Data Anggota Perpustakaan
    </div>
    <div class="card-body">
        <form method="post" action="">
    
    <div class="form-floating mb-3">
        <input class="form-control" id="inputName" type="text" 
        name="nama_anggota" value="<?= $data['Nama_Anggota']; ?>" required />
        <label for="inputName">Nama Anggota</label>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control" id="inputAlamat" type="text" 
        name="alamat" value="<?= $data['Alamat']; ?>" required />
        <label for="inputAlamat">Alamat</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" name="jenis_kelamin" required>
            <option value="">==== Jenis Kelamin ====</option>
            <option value="Laki-laki" <?= $data['Jenis_Kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
            <option value="Perempuan" <?= $data['Jenis_Kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
        </select>
        <label>Jenis Kelamin</label>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control" type="email" 
        name="email" value="<?= $data['Email']; ?>" required />
        <label>Email</label>
    </div>

    <div class="form-floating mb-3">
        <input class="form-control" type="password" 
        name="password" placeholder="Kosongkan jika tidak diubah" />
        <label>Password</label>
    </div>

    <div class="mt-4 mb-3">
        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-warning" value="Simpan Perubahan">
            <a href="index.php?page=data_anggota" class="btn btn-secondary">Batal</a>
        </div>
    </div>

</form>
    </div>
</div>