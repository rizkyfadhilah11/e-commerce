<?php
session_start();
if(!isset($_SESSION['pelanggan'])){
	header('location:login.php');
} else {
	
};

$idorder = $_GET['id'];

include 'koneksi.php';

if(isset($_POST['confirm']))
	{
		
		$userid = $_SESSION['id'];
		$veriforderid = mysqli_query($conn,"SELECT * FROM cart WHERE orderid='$idorder'");
		$fetch = mysqli_fetch_array($veriforderid);
		$liat = mysqli_num_rows($veriforderid);
		
		if($fetch>0){
		$nama = $_POST['nama'];
		$metode = $_POST['metode'];
		$tanggal = $_POST['tanggal'];
			  
		$kon = mysqli_query($conn,"insert into konfirmasi (orderid, id_user, payment, namarekening, tglbayar) 
		values('$idorder','$userid','$metode','$nama','$tanggal')");
		if ($kon){
		
		$up = mysqli_query($conn,"UPDATE cart SET status='Confirmed' WHERE orderid='$idorder'");
		
		echo " <div class='alert alert-success'>
			Terima kasih telah melakukan konfirmasi, team kami akan melakukan verifikasi.
			Informasi selanjutnya akan dikirim via Email
		  </div>
		<meta http-equiv='refresh' content='7; url= index.php'/>  ";
		} else { echo "<div class='alert alert-warning'>
			Gagal Submit, silakan ulangi lagi.
		  </div>
		 <meta http-equiv='refresh' content='3; url= konfirmasi.php'/> ";
		}
		} else {
			echo "<div class='alert alert-danger'>
			Kode Order tidak ditemukan, harap masukkan kembali dengan benar
		  </div>
		 <meta http-equiv='refresh' content='4; url= konfirmasi.php'/> ";
		}
		
		
	};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gummo Ltd | Konfirmasi Pembayaran</title>
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
    <?php require "navbar.php";?>

    <div class="container my-5">
        <h3 class="text-center">Konfirmasi Pembayaran</h3>

    <div class="row my-3">
        <div class="col-lg-9 col-lg-offset-3">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
            <label for="">Kode Order</label>
            <input type="text" name="orderid" value="<?php echo $idorder ?>" disabled>
            </div>
            <div class="form-group mb-4">
                <label for="harga">Nama</label>
                <input type="text" name="nama" class="form-control" required autocomplete="off" required>
            </div>
            <div class="form-group mb-4">
                            <label for="nama">Rekening Tujuan</label>
                            <select name="id_pembayaran" class="form-control">
                                <option selected>Pilih Rekening</option>
                                <?php 
                                $metode = mysqli_query($conn,"SELECT * FROM pembayaran");
                                while($d=mysqli_fetch_array($metode)){
                                    ?>
                                    <option value="<?php echo $d['id']?>"><?php echo $d['metode'];?> | <?= $d['norek'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
            <div class="form-group mb-4">
                <label for="">Tanggal Pembayaran</label>
                <input type="date"  class="form-control" required autocomplete="off" required>
            </div>
            <div class="form-group mb-4">
                <label for="bukti">Bukti Pembayaran</label>
                <input type="file" name="bukti" class="form-control" required autocomplete="off" required>
            </div>
            <div class="form-group full-right mb-4">
               <input type="submit" class="btn btn-primary" name="kirim" value="Konfirmasi Pembayaran"></input>
               <a href="riwayat.php" class="btn btn-danger">Batal</a>
            </div>
        </form>

        </div>
    </div>
    </div>
    

    <?php require "footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>