<?php
include '../config.php';
$url = $base_url . "/hutang.php";

$id_transaksi = $_POST['id_transaksi'];
$id_pelanggan = $_POST['id_pelanggan'];
$tanggal_hutang = $_POST['tanggal_hutang'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

$data = [
    "id_transaksi" => $id_transaksi,
    "id_pelanggan" => $id_pelanggan,
    "tanggal_hutang" => $tanggal_hutang,
    "jumlah" => $jumlah,
    "keterangan" => $keterangan,
    "status" => $status
];

$options = [
    "http" => [
        "header" => "Content-Type: application/json",
        "method" => "PUT",
        "content" => json_encode($data)
    ]
];


$response = file_get_contents($url, false, stream_context_create($options));
// //debugging:
 var_dump($response);
echo "<script>alert('Transaksi hutang berhasil diperbarui!');window.location='hutang.php';</script>";
