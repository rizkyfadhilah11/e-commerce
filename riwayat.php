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
  <title>Gummo Ltd | Daftar Pesanan</title>
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
  <div class="checkout">
		<div class="container">
			<h2 class="text-center">Kamu memiliki <span><?= $itungtrans3 ?> transaksi</span></h2>
			<div class="checkout-right">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr class="text-center">
							<th>No.</th>	
							<th>Kode Order</th>
							<th>Tanggal Order</th>
							<th>Total</th>
							<th>Status</th>
						</tr>
					</thead>
          <?php 	
						$brg=mysqli_query($conn,"SELECT DISTINCT(id_cart), c.orderid, tg_order, status from cart c, detailorder d where c.id_user='$uid' and d.orderid=c.orderid and status!='Cart' order by tg_order DESC");
						$no=1;
						while($b=mysqli_fetch_array($brg)){
					?>
          <tr class="text-center"><form method="post">
						<td class="invert"><?php echo $no++ ?></td>
						<td class="invert"><a href="detail_order.php?id=<?php echo $b['orderid'] ?>"><?php echo $b['orderid'] ?></a></td>					
						<td class="invert"><?php echo $b['tg_order'] ?></td>
						<td class="invert">
						Rp<?php 		$ongkir = 10000;
												$ordid = $b['orderid'];
												$result1 = mysqli_query($conn,"SELECT SUM(qty*harga)+$ongkir AS count FROM detailorder d, produk p where d.orderid='$ordid' and p.id=d.id_produk order by d.id_produk ASC");
												$cekrow = mysqli_num_rows($result1);
												$row1 = mysqli_fetch_assoc($result1);
												$count = $row1['count'];
												if($cekrow > 0){
													echo number_format($count);
													} else {
														echo 'No data';
													}?>;
						
						</td>
            <td class="invert">
							<div class="rem">
								<?php
								if($b['status']=='Payment'){
								echo '
								<a href="konfirmasi.php?id='.$b['orderid'].'" class="btn btn-primary">
								Konfirmasi Pembayaran
								</a>
								';}
								else if($b['status']=='Diproses'){
								echo 'Pesanan Diproses (Pembayaran Diterima)';
								}
								else if($b['status']=='Dikirim'){
									echo 'Pesanan Dikirim';
								} else if($b['status']=='Selesai'){
									echo 'Pesanan Selesai';
								} else if($b['status']=='Dibatalkan'){
									echo 'Pesanan Dibatalkan';
								} else {
									echo 'Konfirmasi diterima';
								}
								
								?>
							</form>
          </tr>
              <?php
						}
					?>
        </table>
      </div>
    </div>
  </div>


  <?php require "footer.php";?>
</body>
</html>