<?php
include_once __DIR__ . "/../database.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$db = new database();


//  LOGIN API
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {

    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    $result = $db->login($username, $password);


    echo json_encode($result);
    exit;
}

// CRUD
function handle_request($method, $db)
{

    switch ($method) {

        case 'GET':
            $data = $db->tampil_user();
            echo json_encode([
                "status" => "success",
                "jumlah" => count($data),
                "data" => $data
            ]);
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->tambah_user($data);
            echo json_encode(["status" => "success", "message" => "User ditambah", "data" => $res]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $res = $db->edit_user($data);
            echo json_encode(["status" => "success", "message" => "User diubah", "data" => $res]);
            break;

        case 'DELETE':
            $id = $_GET['id_user'] ?? null;
            $res = $db->hapus_user($id);
            echo json_encode(["status" => "success", "message" => "User dihapus"]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Method tidak dikenali"]);
    }
}

handle_request($method, $db);
?>