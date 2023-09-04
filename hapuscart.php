<?php 
 session_start();
 $id = $_GET["id"];

 unset($_SESSION['keranjang'][$id]);
 echo "<script>alert('Produk dihapus dari Keranjang');</script>";
 echo "<script>location='cart.php';</script>";
?>