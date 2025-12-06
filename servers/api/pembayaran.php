<?php
include_once __DIR__ . "/../database.php";

function handle_request($method) {
    $db = new database();

    switch ($method) {

        case 'GET':
            $data = $db->tampil_pembayaran();
            echo json_encode([
                "status" => "success",
                "jumlah" => count($data),
                "data" => $data
            ]);
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->tambah_pembayaran($data);
            echo json_encode(["status" => "success", "message" => "Pembayaran ditambah", "data" => $res]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->edit_pembayaran($data);
            echo json_encode(["status" => "success", "message" => "Pembayaran diubah", "data" => $res]);
            break;

        case 'DELETE':
            $id = $_GET['id_pembayaran'] ?? null;
            $res = $db->hapus_pembayaran($id);
            echo json_encode(["status" => "success", "message" => "Pembayaran dihapus"]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Method tidak valid"]);
    }
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
handle_request($method);
?>
