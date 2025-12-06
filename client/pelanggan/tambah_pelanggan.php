<?php
include '../config.php';
$url = $base_url . "/pelanggan.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = [
        "nama_pelanggan" => $_POST['nama_pelanggan'],
        "alamat" => $_POST['alamat'],
        "no_hp" => $_POST['no_hp'],
        "keterangan" => $_POST['keterangan']
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json",
            "method"  => "POST",
            "content" => json_encode($data)
        ]
    ];

    $response = file_get_contents($url, false, stream_context_create($options));

    echo "<script>
        alert('Pelanggan berhasil ditambahkan!');
        window.location='pelanggan.php';
    </script>";
    exit;
}
?>
