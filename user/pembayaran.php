<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/PembayaranController.php";
 
if ($currentUser['role'] !== 'mahasiswa') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}
 
$db = (new Database())->connect();
$controller = new PembayaranController($db);
 
$data = json_decode(file_get_contents("php://input"), true);
$controller->bayar($currentUser['uid'], $data);