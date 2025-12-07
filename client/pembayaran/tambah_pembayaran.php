<?php
include '../config.php';

$url = $base_url . "/pembayaran.php";

// Ambil data dari form
$id_transaksi = $_POST['id_transaksi'];
// $tanggal_bayar = $_POST['tanggal_bayar'];
$jumlah_bayar= $_POST['jumlah_bayar'];
$keterangan = $_POST['keterangan'];
$metode_pembayaran = $_POST['metode_pembayaran'];

// Susun data pembayaran
$data = [
    "id_transaksi" => $id_transaksi,
    // "tanggal_bayar" => $tanggal_bayar,
    "jumlah_bayar" => $jumlah_bayar,
    "keterangan" => $keterangan,
    "metode_pembayaran" => $metode_pembayaran
];

// Siapkan request POST
$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];

// Kirim ke API pembayaran
$response = file_get_contents($url, false, stream_context_create($options));

// //debugging:
//  var_dump($response);
echo "<script>alert('Pembayaran berhasil ditambahkan!');window.location='pembayaran.php';</script>";
?>
