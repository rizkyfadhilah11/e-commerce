<?php
session_start();
  require "koneksi.php";

  $queryproduk = mysqli_query($conn, "SELECT * FROM produk LIMIT 12");
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
    <div class="container-fluid banner d-flex align-items-center">
      <div class="container text-center text-white">
        <h2 class="">Gummo Ltd E-commerce</h2>
        <h4>Mau Cari Produk ?</h4>
        <div class="col-md-8 offset-md-2">
          <form action="produk.php" method="get">
          <div class="input-group input-group-lg my-4">
            <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" 
            aria-describedby="basic-addon2" name="keyword" autocomplete="off">
            <button class="btn btn-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!--kategori-->
    <div class="container-fluid ">
      <div class="container text-center mt-3">
      <h3>Kategori Terlaris</h3>
      <div class="row mt-4">
        <div class="col-md-4 mb-3">
          <div class="kategori baju"></div>
          <h5><a class="nodekor" href="produk.php?kategori=T-shirt">T-Shirt</a></h5>
        </div>
        <div class="col-md-4 mb-3">
          <div class="kategori baju2"></div>
          <h5><a class="nodekor" href="produk.php?kategori=Aksesoris">Tas & Aksesoris</a></h5>
        </div>
        <div class="col-md-4 mb-3">
          <div class="kategori baju3"></div>
          <h5><a class="nodekor" href="produk.php?kategori=Jaket">Jaket</a></h5>
        </div>
      </div>
      </div>
    </div>

  <!--produk-->
    <div class="container-fluid py-4">
      <div class="container text-center">
      <h3>Produk</h3>
      <div class="row mt-5">
        <?php while ($produk = mysqli_fetch_array($queryproduk)) { ?>
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="image-box">
              <img src="image/<?= $produk['gambar'];?>" class="card-img-top">
            </div>
              <div class="card-body">
                <h5 class="card-tittle"><?= $produk['nama_produk'];?></h5>
               <p class="card-text">Rp.<?= number_format($produk['harga']);?></p>
               <a class="btn btn-warning" href="detailproduk.php?id=<?=$produk['id'];?>">Lihat Detail</a>
              </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <a class="btn btn-warning mt-3" href="produk.php">See More</a>
      </div>
    </div>

    <!--about-->
    <div class="container-fluid warna3 py-4">
      <div class="container text-center">
        <h3>Tentang Kami</h3>
        <p class="fs-6 mt-3">
        Gummo Ltd (dibaca Gummo Limited) berdiri tepatnya 28 Aprl 2002, pada awalnya tumbuh dari lini produk sepatu (footwear). Seiring berjalannya waktu, brand ini secara bertahap mula memproduksi berbagai apparel pelengkap street sporty life style seperti t-shirt, jacket, topi, tas, aksesoris dan elemen fashion lainnya. Brand Gummo Ltd berada dibawah naungan CVS. Industries -sebuah umbrella brand yang juga memayungi street brand lokal bernama Sch. Gummo Ltd ini dirancang sebagai implementasi dari positioning yang menitikberatkan pada style yang simple dan mencerminkan High Stamina.
        Setelah hampir 4 tahun bereksistensi dengan menumpang pada pola marketing dan sistem distribusi sang kakak -Sch, akhirnya pada hari kamis, 6 oktober 2005, Gummo Ltd merealisasikan toko pertama bernama Gummo Shop Jl. Sulanjana no.15 Bandung. Kemudian ketika segala sesuatunya dirasakan sudah mencukupi untuk mulai berdiri sendiri maka bertepatan dengan anniversary yang ke 4, Gummo Ltd menyelenggarakan Grand Launching dengan tema High Stamina Debut dengan menggelar kegiatan promosi di toko sekaligus menggelar kompetisi skateboard secara Nasional di Gummo Shop JL.Sulanjana no.15 Bandung.
        Satu tahun kemudian, energi High Stamina yang melekat erat sebagai positioning dan soul bagi Gummo Ltd membuat brand ini seakan-akan tidak akan pernah statis dan stagnant. Gummo Ltd akan selalu mencari celah jalan lalu menerobos dan membuka setiap peluang dari setiap kesempatan yang ada. Energi ini pula yang mendorong Gummo Ltd untuk melakukan SPREADING THE STAMINA AREA PROGRAM, dengan membuka toko kedua Gummo Shop JL.Tebet Utara Dalam No.26 Jakarta Selatan pada bulan September 2006. Dengan demikian High Stamina Energy yang terkandung dalam berbagai movement dan produk Gummo Ltd yang terdiri dari berbagai Apparel seperti : T-Shirt, Jacket, boxer, celana, polo shirt, sweater dan terutama sepatu akan ikut menyebar ke berbagai kalangan muda Jakarta yang aktif dan dinamis.
        Pada tahun 2011, Sch Store menempati tempat baru yang berlokasi di JL.Sultan Agung No.3A-B Bandung dengan tampilan yang lebih fresh dan ukuran toko yang lebih luas sehingga Sch Store yang terletak di JL.Sultan Agung No.13 Bandung diambil alih oleh Gummo dan menjadikannya toko ke-3. Pada tahun 2012, -bertepatan dengan program CVS End of League 2012, Gummo kembali membuka toko terbaru Gummo Shop JL. Cihampelas 103A Bandung. Hanya sayangnya, tidak berselang lama pada bulan Mei 2013 Gummo Shop pertama harus ditutup setelah hampir beroperasi selama 8 tahun di JL.Sulanjana no.15 Bandung.
        </p>
      </div>
    </div>

    <?php require "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>