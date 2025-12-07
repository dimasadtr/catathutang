<?php
include '../config.php';

$url = $base_url . "/hutang.php";

$id_pelanggan = $_POST['id_pelanggan'];
// $tanggal_hutang = $_POST['tanggal_hutang'];
$jumlah = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

$data = [
    "id_pelanggan" => $id_pelanggan,
    // "tanggal_hutang" => $tanggal_hutang,
    "jumlah" => $jumlah,
    "keterangan" => $keterangan
];

// Siapkan request
$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => json_encode($data)
    ]
];


// Kirim ke API
$response = file_get_contents($url, false, stream_context_create($options));

// //debugging:
//  var_dump($response);
echo "<script>alert('Transaksi hutang berhasil ditambahkan!');window.location='hutang.php';</script>";
