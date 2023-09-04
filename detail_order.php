<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['pelanggan'])){
	header('location:login.php');
} else {
	
};
	
	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"SELECT * FROM cart WHERE id_user='$uid' AND status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = isset($fetc ['orderid']) ? $fetc ['orderid'] : '' ;
	$itungtrans = mysqli_query($conn,"SELECT count(detailid) AS jumlahtrans FROM detailorder WHERE orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];
	
if(isset($_POST["update"])){
	$kode = $_POST['idproduk'];
	$jumlah = $_POST['jumlah'];
	$q1 = mysqli_query($conn, "UPDATE detailorder SET qty ='$jumlah' WHERE id_produk='$kode' AND orderid='$orderidd'");
	if($q1){
		echo "Berhasil Update Cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	} else {
		echo "Gagal update cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	}
} else if(isset($_POST["hapus"])){
	$kode = $_POST['idproduk'];
	$q2 = mysqli_query($conn, "DELETE FROM detailorder WHERE id_produk='$kode' AND orderid='$orderidd'");
	if($q2){
		echo "<script>
		alert('Produk dihapus dari keranjang!');
		</script>";
	} else {
		echo "Gagal Hapus";
	}
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
  >
</thead>
<?php 
    $brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p where orderid='$orderidd' and d.id_produk=p.id order by d.id_produk ASC");
	$no=1;
	while($b=mysqli_fetch_array($brg)){
?>   
<tbody>
        <tr>
            <form action="" method="POST">
            <td class="invert"><?php echo $no++ ?></td>
						<td class="text-center"><a href="product.php?id_produk=<?php echo $b['id_produk'] ?>"><img src="image/<?php echo $b['gambar'] ?>" width="100px" height="80px" /></a></td>
						<td class="invert"><?php echo $b['nama_produk'] ?></td>
                        <td><?php echo $b['harga'];?></td>
						<td class="invert"><?= $b['qty'];?></td>
						

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
<div class="checkout-left-basket">
	<h4>Total Harga</h4>
	    <ul>
			<?php 
			$brg=mysqli_query($conn,"SELECT * FROM detailorder d, produk p where orderid='$orderidd' and d.id_produk=p.id order by d.id_produk ASC");
			$no=1;
			$subtotal = 10000;
			while($b=mysqli_fetch_array($brg)){
			$hrg = $b['harga'];
			$qtyy = $b['qty'];
			$totalharga = $hrg * $qtyy;
			$subtotal += $totalharga
			?>
			<li><?php echo $b['nama_produk']?><i> - </i> <span>Rp<?php echo number_format($totalharga) ?> </span></li>
			<?php
			}
			?>
			<li>Total (inc. 10k Ongkir)<i> - </i> <span>Rp<?php echo number_format($subtotal) ?></span></li>
		</ul>
</div>

</div>
<a href="riwayat.php" class="btn btn-warning">Kembali</a>
</div>

<?php require "footer.php"; ?>
</body>
 </html>
