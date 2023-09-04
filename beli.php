<?php
session_start ();
//mendapatkan id dari url
$id = $_GET['id'];

//jika sudah ada produk itu dikeranjang maka ditambah 1
if(isset($_SESSION['keranjang'][$id])){
    $_SESSION['keranjang'][$id]+=1;
}else{
    //jika belum ada produk di kerangjang
    $_SESSION['keranjang'][$id] = 1;
}

echo "<script>alert('Produk Berhasil ditambah ke keranjang belanja')</script>";
echo "<script>location='cart.php';</script>";
?>