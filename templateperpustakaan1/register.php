<?php 



include("koneksi.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_anggota = $_POST['nama_anggota'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cek_email = mysqli_query($conn, "SELECT * FROM anggota WHERE email='$email'");

    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar!');window.location='register.php';</script>";
    } else {
        $insert = mysqli_query($conn, 
            "INSERT INTO anggota (nama_anggota, alamat, jenis_kelamin, email, password)
             VALUES ('$nama_anggota', '$alamat', '$jenis_kelamin', '$email', '$password')"
        );

        if ($insert) {
            echo "<script>alert('Registrasi berhasil!');window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');window.location='register.php';</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Anggota</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="register.php">
                                            <div class="row mb-3">

                                        <div class="form-floating mb-3">
                                                <input class="form-control" id="inputnama_anggota" type="nama_anggota" name="nama_anggota" />
                                                <label for="inputnama_anggota">Nama User</label>
                                            </div>

                                         <div class="form-floating mb-3">
                                                <input class="form-control" id="inputalamat" type="textarea" name="alamat"  />
                                                <label for="inputalamat">Alamat</label>
                                            </div>

                                          
                                              <form>
                                      <div class="form-group"> 
                                        
                                        <label for="jenis_kelamin">Pilih jenis_kelamin</label>
                                           <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                             <option value="">-- Pilih --</option>
                                               <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                          </select>
                                         </div>

                                        
                                        </form> 
                                        
                                         <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="email" placeholder="name@example.com"></input>
                                                <label for="inputEmail">EMAIL </label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputpassword" type="password" name="password" />
                                                <label for="inputpassword">Password</label>
                                                 </div>

                                        <div class="btn-wrapper">
                                  <button type="submit" class="btn-glow">INPUT</button>
                                  </div>

                                             <style>

                                               .form-group {
                                            margin-bottom: 20px;
                                                  }

                                               select {
                                           width: 100%;
                                           padding: 10px;
                                         border-radius: 6px;
                                         border: 1px solid #ccc;
                                            }

                                         .btn-wrapper { 
                                          display: flex;
                                          justify-content: center;
                                      align-items: center;
                                             }

                                            .btn-glow {
                                            background: #2563eb;
                                            color: white;
                                            padding: 12px 25px;
                                            border: none;
                                           border-radius: 8px;
                                           font-size: 16px ;
                                           cursor: pointer;
                                            box-shadow: 0 0 10px #2563eb;
                                          transition: 0.3s;
                                           }

                                             .btn-glow:hover {
                                            box-shadow: 0 0 25px #3b82f6, 0 0 50px #60a5fa;
                                            transform: scale(1.05);
                                              }
                                                  </style>


                                            </div>         

                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">login</a> || <a href="register_user.php">Tambahkan User</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
    