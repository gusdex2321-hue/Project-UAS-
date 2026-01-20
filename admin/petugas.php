<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../controllers/PetugasController.php";


if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

$db = (new Database())->connect();
$controller = new PetugasController($db);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

if ($method === "GET") {
    $controller->index();
} elseif ($method === "POST") {
    $controller->store($data);
} elseif ($method === "PUT" && isset($_GET['id'])) {
    $controller->update($_GET['id'], $data);
} elseif ($method === "DELETE" && isset($_GET['id'])) {
    $controller->delete($_GET['id']);
} else {
    jsonResponse(["message" => "Method tidak diizinkan"], 405);
}
