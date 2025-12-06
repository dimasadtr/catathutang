<?php
include '../config.php';

$id = $_GET['id'];

$url = $base_url . "/hutang.php?id_transaksi=" . $id;

$options = [
    "http" => [
        "method" => "DELETE"
    ]
];

// DELETE ke API
$response = file_get_contents($url, false, stream_context_create($options));

echo "<script>alert('Transaksi hutang berhasil dihapus!');window.location='hutang.php';</script>";
