<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../controllers/UserController.php";
require_once "../helpers/response.php";

$db = (new Database())->connect();
$controller = new UserController($db);


$userId = $currentUser['uid'];
$role = $currentUser['role'];


$allowedRoles = ['mahasiswa', 'petugas'];
if (!in_array($role, $allowedRoles)) {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

if ($method !== "PUT") {
    jsonResponse(["message" => "Method tidak diizinkan"], 405);
}


if (isset($data['role'])) {
    jsonResponse(["message" => "Tidak boleh mengubah role"], 403);
}


if (empty($data['username']) && empty($data['password'])) {
    jsonResponse(["message" => "Tidak ada data untuk diperbarui"], 422);
}

if (isset($data['username'])) {
    $controller->update($userId, [
        'username' => $data['username']
    ]);
}


if (isset($data['password'])) {
    $controller->updatePassword($userId, [
        'password' => $data['password']
    ]);
}

jsonResponse(["message" => "Profil berhasil diperbarui"]);
