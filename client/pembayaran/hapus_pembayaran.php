<?php
include '../config.php';
$id = $_GET['id'];
$url = $base_url . "/pembayaran.php?id_pembayaran=" . $id;

$data = ["id_pembayaran" => $id];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "DELETE",
        "content" => json_encode($data)
    ]
];

$response = file_get_contents($url, false, stream_context_create($options));

// //debugging:
// var_dump($response);

echo "<script>alert('pembayaran berhasil dihapus!');window.location='pembayaran.php';</script>";
?>
