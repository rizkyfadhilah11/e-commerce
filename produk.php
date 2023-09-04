<?php
    session_start();
    require "koneksi.php";

    $querykategori = mysqli_query($conn, "SELECT * FROM kategori");

    //produk berdasarkan pencarian
    if(isset($_GET['keyword'])){
        $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama_produk LIKE '%$_GET[keyword]%'");
    }
    //produk berdasarkan kategori
    else if(isset($_GET['kategori'])){
        $queryIdkategori = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE nama_kategori='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryIdkategori);

        $queryproduk = mysqli_query($conn, "SELECT * FROM produk WHERE id_kategori='$kategoriId[id_kategori]'");
    }
    //semua produk
    else{
        $queryproduk = mysqli_query($conn, "SELECT * FROM produk");
    }

    $countdata = mysqli_num_rows($queryproduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gummo Ltd | Halaman Produk </title>
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
    <div class="container-fluid banner d-flex align-items-center">
      <div class="container text-center text-white">
        <h2>Gummo Ltd E-commerce</h2>
        <h3>Produk</h3>
        </div>
      </div>
    
    <!--kategori-->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori = mysqli_fetch_array($querykategori)){ ?>
                    <a class="dekor" href="produk.php?kategori=<?= $kategori['nama_kategori'];?>">
                        <li class="list-group-item"><?= $kategori['nama_kategori'];?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                    if($countdata<1){
                    ?>
                        <h3 class="text-center my-4">Produk Yang Anda Cari Tidak Tersedia</h3>
                    <?php
                    }
                    ?>

                    <?php while($produk = mysqli_fetch_array($queryproduk)){ ?>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center">
                            <div class="image-box">
                            <img src="image/<?= $produk['gambar'];?>" class="card-img-top" >
                            </div>
                            <div class="card-body">
                                <h5 class="card-tittle"><?= $produk['nama_produk'];?></h5>
                                <p class="card-text">Rp <?= number_format($produk['harga']);?></p>
                                <a class="btn btn-warning" href="detailproduk.php?id=<?=$produk['id'];?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>