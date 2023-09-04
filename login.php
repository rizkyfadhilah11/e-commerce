<?php
    session_start();
    include "koneksi.php";
    if(isset($_SESSION["pelanggan"]) ){
        header("location:index.php");
        exit;
    }

    if(isset($_POST['login']))
	{
	$username = mysqli_real_escape_string($conn,$_POST['username']);
	$pass = mysqli_real_escape_string($conn,$_POST['password']);
	$queryuser = mysqli_query($conn,"SELECT * FROM user WHERE username ='$username'");
	$cariuser = mysqli_fetch_assoc($queryuser);
		
		if( password_verify($pass, $cariuser['password']) ) {
			$_SESSION['id'] = $cariuser['id_user'];
			$_SESSION['username'] = $cariuser['username'];
			$_SESSION['no_hp'] = $cariuser['no_hp'];
			$_SESSION['name'] = $cariuser['nama'];
			$_SESSION['pelanggan'] = "Logged";
			header('location:index.php');
		} else {
			echo 'Username atau password salah';
			header("location:login.php");
		}		
	}
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
    <title>Gummo Ltd | Halaman Login </title>
</head>
<body>
    <?php require "navbar.php";?>

    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <h3 class="card-tittle text-center">Login Pelanggan </h3>
            </div>
            <?php if (isset($error)) : ?>
                <p style="color: red; font-style: italic;">Username dan Password Salah!</p>
                <?php endif; ?>
            <div class="card-text">
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukan Username" autocomplete="off" require>
                </div>
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukan Password" require>
                </div>
                <div class="mb-4">
                    <a class="form-check" href="register.php">Belum punya akun ? Daftar Disini !</a>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="login" class="btn btn-warning" >Masuk</button>
                </div>
                
            </form>
            </div>
        </div>
    </div>
 

    <?php require "footer.php";?>
</body>
</html>