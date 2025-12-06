<?php
include_once __DIR__ . "/../database.php";

function handle_request($method) {
    $db = new database();

    switch ($method) {

        case 'GET':
            $data = $db->tampil_hutang();
            echo json_encode([
                "status" => "success",
                "jumlah" => count($data),
                "data" => $data
            ]);
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->tambah_hutang($data);
            echo json_encode(["status" => "success", "message" => "Hutang ditambah", "data" => $res]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->edit_hutang($data);
            echo json_encode(["status" => "success", "message" => "Hutang diubah", "data" => $res]);
            break;

        case 'DELETE':
            $id = $_GET['id_transaksi'] ?? null;
            $res = $db->hapus_hutang($id);
            echo json_encode(["status" => "success", "message" => "Hutang dihapus"]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Method tidak dikenali"]);
    }
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
handle_request($method);
?>
