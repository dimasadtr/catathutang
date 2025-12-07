<?php 
include '../config.php';

// Ambil ID pembayaran
$id_pembayaran = $_POST['id_pembayaran'];

$url = $base_url . "/pembayaran.php?id_pembayaran=" . $id_pembayaran;

// Data dikirim lewat body PUT
$data = [
    "id_pembayaran"     => $id_pembayaran,
    "id_transaksi"      => $_POST['id_transaksi'],
    "tanggal_bayar"     => $_POST['tanggal_bayar'],
    "jumlah_bayar"      => $_POST['jumlah_bayar'],
    "metode_pembayaran" => $_POST['metode_pembayaran'] ?? '',
    "keterangan"        => $_POST['keterangan']
];

// Konfigurasi PUT
$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "PUT",
        "content" => json_encode($data)
    ]
];

// Eksekusi request
$response = file_get_contents($url, false, stream_context_create($options));

// var_dump($response);

echo "<script>alert('Data pembayaran berhasil diperbarui!');window.location='pembayaran.php';</script>";
