<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../models/UKT.php";
require_once "../helpers/response.php";
 
if ($currentUser['role'] !== 'mahasiswa') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}
 
$db = (new Database())->connect();
$ukt = new UKT($db);
 
$tagihan = $ukt->getByMahasiswa($currentUser['uid']);
 
if (!$tagihan) {
    jsonResponse(["message" => "Tagihan UKT tidak ditemukan"], 404);
}
 
jsonResponse($tagihan);