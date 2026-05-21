<?php
session_start();
include 'koneksi.php'; 



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $password =$_POST['password'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE nama_user='$nama' AND 
    password='$password'");
    $query1 = mysqli_query($conn, "SELECT * FROM anggota WHERE nama_anggota='$nama' AND 
    password='$password'");

    if(mysqli_num_rows($query) >0 ) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['login']= true;
        $_SESSION['email']= $data['email'];
        $_SESSION['nama_user']= $data['nama_user'];
        $_SESSION['role']= $data['role'];

        if($_SESSION['role'] == 'admin') {
            header("location: admin/index.php");
            exit();
        } else if($_SESSION['role'] == 'petugas') {
            header("location: petugas/index.php");
            exit();
        } else {
            header("location: login.php");
            exit();
        }

    } else if (mysqli_num_rows($query1) >0 ){
        $data = mysqli_fetch_assoc($query1);
        $_SESSION['login']     = true;
        $_SESSION['nama_anggota']    = $data['nama_anggota'];
        $_SESSION['password'] = $data['password'];

        header("location: index.php");
        exit();
    } 

    else {
        echo "<script>alert('Email atau Password salah!');window.location='login.php';</script>";
    }
}
?>


   


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="nama_anggota"
                                                 type="text" name="nama"  />
                                                <label for="inputusername">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" 
                                                name="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" 
                                                type="checkbox" value="" />
                                                <label class="form-check-label" 
                                                for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input type="submit" name="login" class="btn btn-primary"
                                                 value="Login">
                                                <input type="reset" name="reset" 
                                                class="btn btn-danger" value="Reset">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                            <a href="register.php">Need an account? Sign up!</a></div>
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
