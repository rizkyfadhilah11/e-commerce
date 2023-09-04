<?php
session_start();

include "koneksi.php";
if(!isset($_SESSION['pelanggan'])){
	header('location:login.php');
} else {
	
};
	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"SELECT * FROM cart WHERE id_user='$uid' AND status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = $fetc['orderid'];
	$itungtrans = mysqli_query($conn,"SELECT count(detailid) AS jumlahtrans FROM detailorder WHERE orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
if(isset($_POST["checkout"])){
	
	$q3 = mysqli_query($conn, "UPDATE cart SET status='Payment' WHERE orderid='$orderidd'");
	if($q3){
		echo "Berhasil Check Out
		<meta http-equiv='refresh' content='1; url= index.php'/>";
	} else {
		echo "Gagal Check Out
		<meta http-equiv='refresh' content='1; url= index.php'/>";
	}
} else {
	
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gummo Ltd | Checkout</title>
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

<div class="container my-3 ">
<h3 class="text-center"> Keranjang Belanja  Anda</h3>
<div class="table-responsive my-5">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th>No</th>	    
	<th>Name</th>
	<th>Gambar</th>
    <th>Harga</th>
	<th>Jumlah</th>
    
</thead>
<?php 
    $brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p WHERE orderid='$orderidd' and d.id_produk=p.id order by d.id_produk ASC");
	$no=1;
	while($b=mysqli_fetch_array($brg)){
?>   
<tbody>
        <tr>
            <form action="" method="POST">
            <td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="product.php?id_produk=<?php echo $b['id_produk'] ?>"><img src="image/<?php echo $b['gambar'] ?>" width="100px" height="80px" /></a></td>
						<td class="invert"><?php echo $b['nama_produk'] ?></td>
                        <td><?php echo $b['harga'];?></td>
						<td><?= $b['qty'];?></td>
						<td class="invert">											
                </form>
                                                         
            </td>

                        <!--quantity-->
									<script>
									$('.value-plus').on('click', function(){
										var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
										divUpd.text(newVal);
									});

									$('.value-minus').on('click', function(){
										var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
										if(newVal>=1) divUpd.text(newVal);
									});
									</script>
								<!--quantity-->
                                <?php
                                    }
                                ?>				       
</tbody>
</table>
<div class="checkout-left">	
	<div class="checkout-left-basket">
		<h4>Total Harga yang harus dibayar</h4>
		<ul>
			<?php 
			$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.id_produk=p.id order by d.id_produk ASC");
			$no=1;
			$subtotal = 0;
			while($b=mysqli_fetch_array($brg)){
			$hrg = $b['harga'];
			$qtyy = $b['qty'];
			$totalharga = $hrg * $qtyy;
			$subtotal += $totalharga;
			}
			?>
        <h3><input type="text" value="Rp<?php echo number_format($subtotal) ?>" disabled \></h3>
		</ul>
	</div>
	<br>
	<div class="checkout-left-basket" style="width:80%;margin-top:60px;">
		<div class="checkout-left-basket">
			<h4>Kode Order Anda</h4>
			<h3><input type="text" value="<?php echo $orderidd ?>" disabled \></h3>
		</div>
	</div>
				
				<div class="clearfix"> </div>
			</div>
<br>
</div>
<br>
<center>
    <h4>Silahkan melakukan pembayaran sesuai jumlah yang tertera diatas</h4>
<?php 
	$metode = mysqli_query($conn,"SELECT * FROM pembayaran");			
	while($p=mysqli_fetch_array($metode)){
	?>	
		<img src="image/<?php echo $p['logo'] ?>" width="300px" height="200px"><br>
        <h4><?php echo $p['metode'] ?> - <?php echo $p['norek'] ?><br>
        atas nama. <?php echo $p['atas_nama'] ?></h4><br>
        <br>
		<hr>			
<?php
	}
?>
<p>Orderan anda Akan Segera kami proses 1x24 Jam Setelah Anda Melakukan Pembayaran ke ATM kami dan menyertakan informasi pribadi yang melakukan pembayaran seperti Nama Pemilik Rekening / Sumber Dana, Tanggal Pembayaran, Metode Pembayaran dan Jumlah Bayar.</p>
</center>
<form method="post">
	<input type="submit" class="form-control btn btn-success" name="checkout" value="I Agree and Check Out" \>
</form>
</div>
</div>

<?php require "footer.php";?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
  