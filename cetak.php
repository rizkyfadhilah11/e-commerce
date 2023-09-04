<?php

use Mpdf\Tag\Center;

require_once __DIR__ . '/vendor/autoload.php';

include "koneksi.php";

$mpdf = new \Mpdf\Mpdf();


// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

$tgl_mulai = $_GET["tglm"];
$tgl_selesai = $_GET["tgls"];
$semuadata = array();
$ambil = mysqli_query($conn, "SELECT * FROM pembelian LEFT JOIN user ON pembelian.id_user = user.id WHERE tgl_pembelian
        BETWEEN '$tgl_mulai' AND '$tgl_selesai' ");
while($pecah=mysqli_fetch_assoc($ambil)){
    $semuadata[]=$pecah;
}

$isi= "<center><h3>Laporan Penjualan Gummo limited</h3></center>";
$isi.= "<h4>Dari ".date("d F Y", strtotime($tgl_mulai))." s/d ".date("d F Y", strtotime($tgl_selesai))." </h4>";
$isi.= "<table cellpadding='9' cellspacing='0' border='1'>";
    $isi.= "<thead>";
        $isi.= "<tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Pembelian</th>
                <th>Jumlah</th>                            
            </tr>";
    $isi.= "</thead>";
    $isi.= "<tbody>";
            $total = 0;
            foreach ($semuadata as $key => $value):
            $total += $value["total_pembelian"];
            $nomor = $key+1;
            $isi.= "<tr>";
                    $isi.= "<td>".$nomor."</td>";
                    $isi.= "<td>".$value["nama"]."</td>";
                    $isi.= "<td>". date("d F Y", strtotime($value["tgl_pembelian"]))."</td>";
                    $isi.= "<td> Rp. ".number_format($value["total_pembelian"])."</td>";
                    $isi.= "</tr>";                       
            endforeach ;                                       
            $isi.= "</tbody>";
            $isi.= "<tfoot>";
                    $isi.= "<tr>";
                     $isi.= "<th colspan='3'>Total</th>";
                       $isi.= "<th>Rp. ".number_format($total)."</th>";
                      $isi.= "</tr>";
                    $isi.= "</tfoot>";
$isi.= "</table>";


$mpdf->WriteHTML($isi);
$mpdf->Output();

 ?>
