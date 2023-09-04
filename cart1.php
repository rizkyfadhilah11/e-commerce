<?php
session_start();

include "koneksi.php";
if(!isset($_SESSION["pelanggan"])){
  header("location:login.php");
  exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gummo Ltd | Keranjang Belanja</title>
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
<div class="container my-3">
  <h3 class="text-center">Keranjang Belanja Anda</h3>
  <div class="table-responsive my-5">
  <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr class="text-center">
      <th>No</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Gambar</th>
      <th>Jumlah</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
   
      <?php $no = 1;?>
      <?php foreach($_SESSION["keranjang"] as $id => $jumlah): ?>
      <?php
      $ambil = mysqli_query($conn, "SELECT * FROM produk  WHERE id= '$id'");
      $pecah = mysqli_fetch_array($ambil);
      $subtotal = $pecah['harga'] * $jumlah;
      ?>
      <tr class="text-center">
        <td><?= $no++;?></td>
        <td><?= $pecah['nama_produk'];?></td>
        <td>Rp.<?= number_format($pecah['harga']) ;?></td>
        
        <td>
          <img src="image/<?= $pecah['gambar'];?>" alt="" width="70">
        </td>
        <td><?=$jumlah;?></td>
        <td><?= number_format($subtotal) ;?></td>
        <td>
          <a href="hapuscart.php?id=<?= $id;?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
        </td>

      </tr>
      <?php endforeach ?>
    </tbody>
    <?php
          if(empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang'])) {
          echo "<h4>Keranjang Kosong, Silahkan Belanja Dulu !</h4>";
          }
      ?>
  </table>
    <a href="produk.php" class="btn btn-warning">Lanjut Belanja</a>
    <a href="checkout.php" class="btn btn-primary">Checkout</a>
  </div>
</div>
<?php require "footer.php";?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
  