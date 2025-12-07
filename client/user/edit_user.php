<?php
include '../config.php';
$url = $base_url . "/user.php";

// data form
$id       = $_POST['id_user'];
$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'] ?? '';
$email    = $_POST['email'];
$role     = $_POST['role'];

// Data ke API
$data = [
    "id_user" => $id,
    "nama" => $nama,
    "username" => $username,
    "password" => $password,
    "email" => $email,
    "role" => $role
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

echo "<script>alert('Data user berhasil diperbarui!');window.location='user.php';</script>";
?>