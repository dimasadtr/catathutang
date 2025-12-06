<?php
include '../config.php';
$id = $_GET['id'];
$url = $base_url . "/pelanggan.php?id_pelanggan=" . $id;

$data = ["id_pelanggan" => $id];

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

echo "<script>alert('Pelanggan berhasil dihapus!');window.location='pelanggan.php';</script>";
?>
