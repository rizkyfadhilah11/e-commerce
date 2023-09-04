<?php
session_start();
  require "koneksi.php";


  $id = $_GET["id"];
  $queryedit = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
  $edit = mysqli_fetch_array($queryedit);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gummo Ltd | E-commerce </title>
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
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    
    <?php require "navbar.php"; ?>
    <!--banner-->
<div class="container mt-4">
    <h3 class="text-center"> Edit Profile</h3>
    <form action="" method="POST" enctype="">
                        <div class="form-group">
                            <label >Nama Lengkap</label>
                            <input type="text" name="nama" id="" class="form-control" required autofocus autocomplete="off" required value="<?= $edit["nama"];?>">
                        </div>                   
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="" class="form-control" required autocomplete="off" required value="<?=$edit["username"];?>">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Email</label>
                            <input type="email" name="email" class="form-control" required autocomplete="off" required  value="<?=$edit["email"];?>">
                        </div>                    
                        <div class="form-group">
                            <label >Password</label>
                            <input name="gambar" type="password" class="form-control" value="<?=$edit["password"];?>">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Konfirmasi Password</label>
                            <input type="password" name="password2" class="form-control" value="">
                        </div>
                        <div class="form-group mt-3 mb-3">				
                            <input  type="submit" name="add" value="Simpan" class="btn btn-primary">
                      </div>
                    </form>
</div>

  
    
                    <?php require "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>>