<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../models/UKT.php";
require_once "../helpers/response.php";

$db = (new Database())->connect();
$ukt = new UKT($db);

if ($currentUser['role'] === 'mahasiswa') {
    
    $tagihan = $ukt->getByMahasiswa($currentUser['uid']);
} elseif (in_array($currentUser['role'], ['admin','petugas'])) {
    
    if (!isset($_GET['mahasiswa_id'])) {
        jsonResponse(["message" => "mahasiswa_id harus disertakan"], 422);
    }

    $mahasiswa_id = (int)$_GET['mahasiswa_id'];
    $tagihan = $ukt->getByMahasiswa($mahasiswa_id);
} else {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

if (!$tagihan) {
    jsonResponse(["message" => "Tagihan UKT tidak ditemukan"], 404);
}

jsonResponse($tagihan);
