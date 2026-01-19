<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/MahasiswaController.php";

if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

$db = (new Database())->connect();
$controller = new MahasiswaController($db);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

if ($method === "GET") {
    $controller->index();
} elseif ($method === "POST") {
    $controller->store($data);
} else {
    jsonResponse(["message" => "Method tidak diizinkan"], 405);
}