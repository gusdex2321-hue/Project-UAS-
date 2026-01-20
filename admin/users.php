<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../controllers/UserController.php";
require_once "../helpers/response.php";

if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

$db = (new Database())->connect();
$controller = new UserController($db);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    case "GET":
        $id ? $controller->show($id) : $controller->index();
        break;

    case "POST":
        $controller->store($data);
        break;

    case "PUT":
        if (!$id) {
            jsonResponse(["message" => "ID user wajib diisi"], 422);
        }

        // update username & role
        if (isset($data['username']) || isset($data['role'])) {
            $controller->update($id, $data);
        }

        // update password
        if (isset($data['password'])) {
            $controller->updatePassword($id, $data);
        }

        jsonResponse(["message" => "Data user berhasil diperbarui"]);
        break;

    case "DELETE":
        $controller->destroy($id);
        break;

    default:
        jsonResponse(["message" => "Method tidak diizinkan"], 405);
}
