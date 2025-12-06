<?php
include_once __DIR__ . "/../database.php";

function handle_request($method) {
    $db = new database();

    switch ($method) {
        
        // TAMPILKAN SEMUA DATA
        case 'GET':
            $data = $db->tampil_pelanggan();
            echo json_encode([
                "status" => "success",
                "jumlah" => count($data),
                "data" => $data
            ]);
            break;

        //  TAMBAH DATA
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->tambah_pelanggan($data);
            echo json_encode(["status" => "success", "message" => "Data pelanggan ditambah", "data" => $res]);
            break;

        // UPDATE DATA
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->edit_pelanggan($data);
            echo json_encode(["status" => "success", "message" => "Data pelanggan diubah", "data" => $res]);
            break;

        // DELETE
        case 'DELETE':
            $id = $_GET['id_pelanggan'] ?? null;
            $res = $db->hapus_pelanggan($id);
            echo json_encode(["status" => "success", "message" => "Data pelanggan dihapus"]);
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
