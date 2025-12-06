<?php
include '../config.php';
$url = $base_url . "/pelanggan.php";

// data form
$id     = $_POST['id_pelanggan'];
$nama   = $_POST['nama_pelanggan'];
$alamat = $_POST['alamat'];
$no_hp  = $_POST['no_hp'];
$keterangan = $_POST['keterangan'];

// Data ke API
$data = [
    "id_pelanggan" => $id,
    "nama_pelanggan" => $nama,
    "alamat" => $alamat,
    "no_hp" => $no_hp,
    "keterangan" => $keterangan
];

// request PUT
$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "PUT",
        "content" => json_encode($data)
    ]
];

// Kirim ke API
$response = file_get_contents($url, false, stream_context_create($options));

// //debugging:
//  var_dump($response);

echo "<script>alert('Data pelanggan berhasil diperbarui!');window.location='pelanggan.php';</script>";
?>
