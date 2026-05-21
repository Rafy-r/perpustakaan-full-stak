<?php
include '../koneksi.php';

/** @var mysqli $conn */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_buku = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $foto = null;



    if (!empty($_FILES['foto']['name'])) {
        $namaFoto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $ukuran = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];
        $ext = strtolower(pathinfo($namaFoto, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        $maxSize = 2 * 1024 * 1024;

        if ($error !== UPLOAD_ERR_OK) {
            echo "<script>alert('Error upload file. Kode: $error');</script>";
        } 
        elseif (!in_array($ext, $allowed)) {
            echo "<script>alert('Format foto harus JPG/JPEG/PNG');</script>";
        } 
        elseif ($ukuran > $maxSize) {
            echo "<script>alert('Ukuran foto maksimal 2MB');</script>";
        } 
        else {
            $uploadDir = "../images/admin/cover/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fotoBaru = time() . '_' . uniqid() . '.' . $ext;
            $path = $uploadDir . $fotoBaru;

            if (move_uploaded_file($tmp, $path)) {
                $foto = $fotoBaru;
            } else {
                echo "<script>alert('Gagal upload foto. Periksa permission folder.');</script>";
            }
        }
    }

    $stmt = mysqli_prepare($conn, "
        INSERT INTO buku (Judul_Buku, Pengarang, Penerbit, Tahun_Terbit, Foto) 
        VALUES (?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param($stmt, "sssss", $judul_buku, $pengarang, $penerbit, $tahun_terbit, $foto);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Data berhasil ditambahkan');
            window.location.href = 'index.php?page=data_buku';
        </script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
    
    mysqli_stmt_close($stmt);
}
?>
    

<h1 class="mt-4 ms-5 me-3">Tambah Data Buku</h1>
<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">Dashboard / Tambah Data Buku</span>
</div>
<div class="card mb-4 ms-5 me-3">
    <div class="card-header">
        <i class="fas fa-plus me-1"></i>
        Form Tambah Data Buku Perpustakaan
    </div>
    <div class="card-body">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-floating mb-3">
                <input class="form-control" id="inputName" type="text" placeholder="Masukkan Judul Buku" name="judul_buku" required />
                <label for="inputName">Judul Buku</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputPengarang" type="text" placeholder="Masukkan Nama Pengarang" name="pengarang" required />
                <label for="inputPengarang">Pengarang</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputPenerbit" type="text" placeholder="Masukkan Nama Penerbit" name="penerbit" required />
                <label for="inputPenerbit">Penerbit</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="inputTahun" type="number" placeholder="Masukkan Tahun Terbit" name="tahun_terbit" required />
                <label for="inputTahun">Tahun Terbit</label>
            </div>
            <div class="mb-3">
                <label for="inputFoto" class="form-label">Foto Cover Buku</label>
                <input type="file" class="form-control" id="inputFoto" name="foto" accept="image/jpg,image/jpeg,image/png">
            </div>
            <div class="mt-4 mb-3">
                <div class="d-flex justify-content-between">
                    <input type="submit" class="btn btn-primary btn-block" value="Tambah Data">
                    <input type="reset" class="btn btn-danger btn-block" value="Reset Data">
                </div>
            </div>
        </form>
    </div>
</div>