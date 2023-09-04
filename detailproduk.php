<?php

session_start();


    require "koneksi.php";

    $id = $_GET["id"];
    $detailproduk = mysqli_query($conn, "SELECT * FROM produk  WHERE id =$id");
    $detail = mysqli_fetch_array($detailproduk);

    $produklainnya = mysqli_query($conn, "SELECT * FROM produk WHERE id_kategori='$detail[id_kategori]' LIMIT 4");

    
    if(isset($_POST['addprod'])){
        if(!isset($_SESSION['pelanggan']))
            {	
                header('location:login.php');
            } else {
                    $ui = $_SESSION['id'];
                    $cek = mysqli_query($conn,"SELECT * FROM cart WHERE id_user='$ui' AND status='Cart'");
                    $liat = mysqli_num_rows($cek);
                    $f = mysqli_fetch_array($cek);
                    $orid = isset($f['orderid']) ? $f['orderid'] : '';
                    
                    //kalo ternyata udeh ada order id nya
                    if($liat>0){
                                
                                //cek barang serupa
                                $cekbrg = mysqli_query($conn, "SELECT * FROM detailorder WHERE id_produk='$id' AND orderid='$orid'");
                                $liatlg = mysqli_num_rows($cekbrg);
                                $brpbanyak = mysqli_fetch_array($cekbrg);
                                $jmlh = $brpbanyak['qty'];
                                
                                //kalo ternyata barangnya ud ada
                                if($liatlg>0){
                                    $i=1;
                                    $baru = $jmlh + $i;
                                    
                                    $updateaja = mysqli_query($conn,"UPDATE detailorder SET qty='$baru' WHERE orderid='$orid' AND id_produk='$id'");
                                    
                                    if($updateaja){
                                        echo " <div class='alert alert-success'>
                                    Barang sudah pernah dimasukkan ke keranjang, jumlah akan ditambahkan
                                  </div>
                                  <meta http-equiv='refresh' content='5; url= cart.php?id_produk=".$id."'/>";
                                    } else {
                                        echo "<div class='alert alert-warning'>
                                    Gagal menambahkan ke keranjang
                                  </div>
                                  <meta http-equiv='refresh' content='5; url= product.php?id_produk=".$id."'/>";
                                    }
                                    
                                } else {
                                
                                $tambahdata = mysqli_query($conn,"INSERT INTO detailorder (orderid,id_produk,qty,id_varian) VALUES ('$orid','$id','1', '$size')");
                                if ($tambahdata){
                                echo " <div class='alert alert-success'>
                                    Berhasil menambahkan ke keranjang
                                  </div>
                                <meta http-equiv='refresh' content='5; url= cart.php?id_produk=".$id."'/>  ";
                                } else { echo "<div class='alert alert-warning'>
                                    Gagal menambahkan ke keranjang
                                  </div>
                                 <meta http-equiv='refresh' content='5; url= product.php?id_produk=".$id."'/> ";
                                }
                                };
                    } else {
                        
                        //kalo belom ada order id nya
                            $oi = crypt(rand(22,999),time());
                            
                            $bikincart = mysqli_query($conn,"INSERT INTO cart (orderid, id_user) VALUES ('$oi','$ui')");
                            
                            if($bikincart){
                                $tambahuser = mysqli_query($conn,"INSERT INTO detailorder (orderid,id_produk,qty) values('$oi','$id','1')");
                                if ($tambahuser){
                                echo " <div class='alert alert-success'>
                                    Berhasil menambahkan ke keranjang
                                  </div>
                                <meta http-equiv='refresh' content='5; url= cart.php?id_produk=".$id."'/>  ";
                                } else { echo "<div class='alert alert-warning'>
                                    Gagal menambahkan ke keranjang
                                  </div>
                                 <meta http-equiv='refresh' content='5; url= product.php?idproduk=".$id."'/> ";
                                }
                            } else {
                                echo "gagal bikin cart";
                            }
                    }
            }
    };

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gummo Limited | Detail Produk</title>
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
    
    <div class="container-fluid py-3">
        <div class="container">
            <h3 class="text-center mb-5">Detail Produk</h3>           
            <div class="row">
                <div class="col-md-5">
                    
                    <img src="image/<?=$detail['gambar'];?>" alt="" width="70%">
                </div>
                <div class="col-md-6 offset-md-1">
                    <h3><?= $detail['nama_produk'];?></h3>
                    <select name="" class="form-select">
                        <option value="">Pilih Ukuran</option>
                        <?php 
                              $ukuran = mysqli_query($conn, "SELECT * FROM varian");
                                while($d=mysqli_fetch_array($ukuran)){
                                    ?>
                                    <option value="<?php echo $d['id_varian'];?> "><?= $d['ukuran'];?></option>
                                    <?php
                                }
                        ?>
                    </select>
                    <p><?= $detail['deskripsi'];?></p>
                    <p>Rp. <?= number_format($detail['harga']);?></p>
                    <p>Stok : <?=$detail['quantity'];?></p>
                    <div class="snipcart-details agileinfo_single_right_details">
							<form action="#" method="post">
								<fieldset>
									<input type="hidden" name="idprod" value="<?php echo $id ?>">
                                    <input type="hidden" name="idvarian" value="<?= $d['id_varian'];?>">
									<input type="submit" name="addprod" value="Add to cart" class="btn btn-warning">
								</fieldset>
							</form>
						</div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- produk serupa-->
    <div class="container-fluid py-4">
        <div class="container text-center">
            <h3>Produk Serupa Lainnya</h3>
            <div class="row mt-5">
                <?php while($produk = mysqli_fetch_array($produklainnya)){ ?>
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="image-box">
                        <img src="image/<?= $produk['gambar'];?>" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h5 class="card-tittle"><?= $produk['nama_produk'];?></h5>
                            <p class="card-text text-truncate"><?= $produk['deskripsi'];?></p>
                            <p class="card-text">Rp <?= number_format($produk['harga']);?></p>
                            <a class="btn btn-warning" href="detailproduk.php?id=<?=$produk['id'];?>">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>