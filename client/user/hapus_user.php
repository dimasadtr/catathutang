<?php
include '../config.php';
$id = $_GET['id'];
$url = $base_url . "/user.php?id_user=" . $id;

$data = ["id_user" => $id];

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

echo "<script>alert('User berhasil dihapus!');window.location='user.php';</script>";
?>