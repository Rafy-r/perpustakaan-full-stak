<?php
include '../koneksi.php';

if (!isset($conn) && isset($koneksi)) {
    $conn = $koneksi;
}

/** @var mysqli $conn */

// Cek ID
if (!isset($_GET['id'])) {
    die("ID buku tidak ditemukan");
}

$id = $_GET['id'];

// Ambil data buku
$query = mysqli_query($conn, "SELECT * FROM buku WHERE Id_Buku = '$id'");

if (!$query) {
    die("Query Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($query);

// Cek data ada atau tidak
if (!$data) {
    die("Data buku tidak ditemukan");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $judul_buku  = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $pengarang   = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $penerbit    = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);

    $foto = $data['Foto'];

    // Upload foto
    if (!empty($_FILES['foto']['name'])) {

        $namaFoto = $_FILES['foto']['name'];
        $tmp      = $_FILES['foto']['tmp_name'];

        $ext = strtolower(pathinfo($namaFoto, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {

            $fotoBaru = time() . '_' . $namaFoto;

            $path = "../images/admin/cover/" . $fotoBaru;

            if (move_uploaded_file($tmp, $path)) {

                // Hapus foto lama
                if (
                    !empty($data['Foto']) &&
                    file_exists("../images/admin/cover/" . $data['Foto'])
                ) {
                    unlink("../images/admin/cover/" . $data['Foto']);
                }

                $foto = $fotoBaru;

            } else {

                echo "<script>alert('Gagal upload foto');</script>";
            }

        } else {

            echo "<script>alert('Format foto harus JPG/JPEG/PNG');</script>";
        }
    }

    // Update data
    $update = mysqli_query($conn, "
        UPDATE buku SET
            Judul_Buku = '$judul_buku',
            Pengarang = '$pengarang',
            Penerbit = '$penerbit',
            Tahun_Terbit = '$tahun_terbit',
            Foto = '$foto'
        WHERE Id_Buku = '$id'
    ");

    if ($update) {

        echo "
        <script>
            alert('Data berhasil diubah');
            window.location.href = 'index.php?page=data_buku';
        </script>
        ";

        exit;

    } else {

        echo "
        <script>
            alert('Gagal mengubah data: " . mysqli_error($conn) . "');
        </script>
        ";
    }
}
?>

<h1 class="mt-4 ms-5 me-3">Edit Data Buku</h1>

<div class="breadcrumb mb-4 ms-5 me-3">
    <span class="breadcrumb-item active">
        Dashboard / Edit Data Buku
    </span>
</div>

<div class="card mb-4 ms-5 me-3">

    <div class="card-header">
        <i class="fas fa-edit me-1"></i>
        Form Edit Data Buku Perpustakaan
    </div>

    <div class="card-body">

        <form method="post" action="" enctype="multipart/form-data">

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="inputName"
                    type="text"
                    placeholder="Masukkan Judul Buku"
                    name="judul_buku"
                    value="<?= htmlspecialchars($data['Judul_Buku']); ?>"
                    required
                />
                <label for="inputName">Judul Buku</label>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="inputPengarang"
                    type="text"
                    placeholder="Masukkan Nama Pengarang"
                    name="pengarang"
                    value="<?= htmlspecialchars($data['Pengarang']); ?>"
                    required
                />
                <label for="inputPengarang">Pengarang</label>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="inputPenerbit"
                    type="text"
                    placeholder="Masukkan Nama Penerbit"
                    name="penerbit"
                    value="<?= htmlspecialchars($data['Penerbit']); ?>"
                    required
                />
                <label for="inputPenerbit">Penerbit</label>
            </div>

            <div class="form-floating mb-3">
                <input
                    class="form-control"
                    id="inputTahun"
                    type="number"
                    placeholder="Masukkan Tahun Terbit"
                    name="tahun_terbit"
                    value="<?= htmlspecialchars($data['Tahun_Terbit']); ?>"
                    required
                />
                <label for="inputTahun">Tahun Terbit</label>
            </div>

            <div class="mb-3">

                <label for="inputFoto" class="form-label">
                    Foto Cover Buku
                </label>

                <?php if (!empty($data['Foto'])) : ?>

                    <div class="mb-2">
                        <img
                            src="../images/admin/cover/<?= htmlspecialchars($data['Foto']); ?>"
                            alt="Cover"
                            width="100"
                        >

                        <p class="text-muted small mt-1">
                            Foto saat ini. Upload baru untuk mengganti.
                        </p>
                    </div>

                <?php endif; ?>

                <input
                    type="file"
                    class="form-control"
                    id="inputFoto"
                    name="foto"
                    accept="image/jpg,image/jpeg,image/png"
                >

            </div>

            <div class="mt-4 mb-3">

                <div class="d-flex justify-content-between">

                    <input
                        type="submit"
                        class="btn btn-warning btn-block"
                        value="Simpan Perubahan"
                    >

                    <a
                        href="index.php?page=data_buku"
                        class="btn btn-secondary btn-block"
                    >
                        Batal
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>