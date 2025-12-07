<?php

session_set_cookie_params([
    'path' => '/',
]);

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../config.php';

$url = $base_url . "/user.php?action=login";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = [
        "username" => $_POST['username'],
        "password" => $_POST['password']
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json",
            "method"  => "POST",
            "content" => json_encode($data)
        ]
    ];

    $response = file_get_contents($url, false, stream_context_create($options));
    $res = json_decode($response, true);

    if (isset($res["status"]) && $res["status"] === "success") {

        $_SESSION["user"] = [
            "id_user"  => $res["user"]["id_user"],
            "username" => $res["user"]["username"],
            "role"     => $res["user"]["role"]
        ];
        header("Location: ../../dashboard.php");
        exit;

    } else {
        $msg = $res["message"] ?? "Login gagal!";
        header("Location: ../../index.php?msg=" . urlencode($msg));
        exit;
    }
}
?>
