<?php
session_start();

include "koneksi.php";
if(!isset($_SESSION["pelanggan"])){
  header("location:login.php");
  exit;
}
require "item.php";

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

<?php 


if(isset($_GET['id']) && !isset($_POST['update']))  { 
	$sql = "SELECT * FROM produk WHERE id=".$_GET['id'];
	$result = mysqli_query($conn, $sql);
	$product = mysqli_fetch_object($result); 
	$item = new Item();
	$item->id = $product->id;
	$item->nama_produk = $product->nama_produk;
    $item->gambar = $product->gambar;
	$item->harga = $product->harga;
    $iteminstock = $product->quantity;
	$item->quantity = 1;;
	// Check product is existing in cart
	$index = -1;
	$cart = unserialize(serialize($_SESSION['cart'])); // set $cart as an array, unserialize() converts a string into array
	for($i=0; $i<count($cart);$i++)
		if ($cart[$i]->id == $_GET['id']){
			$index = $i;
			break;
		}
		if($index == -1) 
			$_SESSION['cart'][] = $item; // $_SESSION['cart']: set $cart as session variable
		else {
			
			if (($cart[$index]->quantity) < $iteminstock)
				 $cart[$index]->quantity ++;
			     $_SESSION['cart'] = $cart;
		}
}
// Delete product in cart
if(isset($_GET['index']) && !isset($_POST['update'])) {
	$cart = unserialize(serialize($_SESSION['cart']));
	unset($cart[$_GET['index']]);
	$cart = array_values($cart);
	$_SESSION['cart'] = $cart;
}
// Update quantity in cart
if(isset($_POST['update'])) {
  $arrQuantity = $_POST['quantity'];
  $cart = unserialize(serialize($_SESSION['cart']));
  for($i=0; $i<count($cart);$i++) {
     $cart[$i]->quantity = $arrQuantity[$i];
  }
  $_SESSION['cart'] = $cart;
}
?>

<div class="container my-3 ">
<h3 class="text-center"> Keranjang Belanja  Anda</h3>
<div class="table-responsive my-5">
<form method="POST">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th>No</th>	    
	<th>Name</th>
	<th>Gambar</th>
    <th>Harga</th>
	<th>Jumlah</th>
    <th>Sub Total</th>
    <th>Option</th>
</thead>   
<tbody>	 
</tr>
<?php $no = 1; ?>
<?php 
     $cart = unserialize(serialize($_SESSION['cart']));
 	 $s = 0;
 	 $index = 0;
 	for($i=0; $i<count($cart); $i++){
 		$s += $cart[$i]->harga * $cart[$i]->quantity;
 ?>	
   <tr>
        <td><?= $no++;?></td>
   		<td> <?php echo $cart[$i]->nama_produk; ?> </td>
        <td> <img src="image/<?php echo $cart[$i]->gambar; ?>" alt="" width="50"> </td>
   		<td>Rp. <?php echo number_format($cart[$i]->harga); ?> </td>
        <td> <input type="number" class="form-control" min="1" value="<?php echo $cart[$i]->quantity; ?>" name="quantity[]"> </td>  
        <td>Rp. <?php echo number_format($cart[$i]->harga * $cart[$i]->quantity); ?> </td> 
        <td class="text-center"><a href="cart.php?index=<?php echo $index; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger" ><i class="fa-solid fa-trash"></i></a> </td>
   </tr>
 	<?php 
	 	$index++;
 	} ?>
 	<tr>
 		<td colspan="5" style="text-align:right; font-weight:bold">Tambah
         <input  type="image"  name="update" src="image/save.png" width="20" alt="Save Button">
         <input type="hidden" name="update">
 		</td>
 		<td> <?php echo $s; ?> </td>
 	</tr>
</tbody>
</table>
</form>
<a href="produk.php" class="btn btn-warning">Lanjut Belanja</a>
<a href="checkout.php" class="btn btn-primary">Checkout</a>
</div> 
</div>


<?php 
if(isset($_GET["id"]) || isset($_GET["index"])){
 header('Location: cart.php');
} 
?>

<?php require "footer.php"; ?>
</body>
 </html>
