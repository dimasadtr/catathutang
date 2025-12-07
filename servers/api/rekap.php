<?php
include "../database.php";
$db = new database();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

echo json_encode([
    "status" => "success",
    "data" => $db->get_rekap_hutang(),
    "total_pelanggan" => $db->total_pelanggan(),
    "last_hutang" => $db->last_hutang(),
    "last_bayar" => $db->last_bayar()
]);
