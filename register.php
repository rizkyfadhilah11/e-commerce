<?php
include "koneksi.php";

    if(isset($_POST["register"])){
        if(registrasi($_POST) > 0){
            echo "<script>
                    alert('Registrasi berhasil, Silahkan Melakukan Login!');
                    document.location.href = 'index.php';
                    </script>";
        }else {
            echo mysqli_error($conn);
        }
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootsrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;500&display=swap" rel="stylesheet">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style.css">
    <title>Gummo Ltd | Halaman Registrasi</title>
</head>
<body>

    <?php require "navbar.php";?>
    <div class="global-container">
        <div class="card register-form">
            <div class="card-body">
                <h3 class="card-tittle text-center">Form Daftar Akun </h3>
            </div>
            <div class="card-text">
            <form action="" method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama </label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" autocomplete="off" require>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"  placeholder="Username" autocomplete="off" require>
                    </div>
                <div class="form-group row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"  placeholder="Email" autocomplete="off" require>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputPassword1" class="form-label">No Telepon</label>
                        <input type="text" name="notelp" class="form-control"  placeholder="No Telepon" autocomplete="off" require>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control"  require>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputPassword1" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password2" placeholder="Konfirmasi Password" class="form-control"  require>
                    </div>
                </div>
                <div class="mb-3 ">
                    <a class="form-check" href="login.php">Sudah punya akun ? </a>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="register" class="btn btn-success">Daftar</button>
                </div>
            </form>
            </div>
        </div>
    </div>
 
    <?php require "footer.php";?>
</body>
</html>