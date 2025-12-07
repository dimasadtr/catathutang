<?php
session_start();
include '../config.php';
$url = $base_url . "/user.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = [
        // include id_user if provided (optional)
        "id_user" => isset($_POST['id_user']) && $_POST['id_user'] !== '' ? $_POST['id_user'] : null,
        "nama" => $_POST['nama'],
        "username" => $_POST['username'],
        "password" => $_POST['password'],
        "email" => $_POST['email'],
        "role" => $_POST['role']
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json",
            "method"  => "POST",
            "content" => json_encode($data)
        ]
    ];

    $response = file_get_contents($url, false, stream_context_create($options));

    if ($response === FALSE) {
        die("Error: API tidak merespon.");
    }

    $_SESSION['api_response'] = $response;

    header("Location: user.php");
    exit;
}