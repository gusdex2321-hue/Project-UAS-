<?php
require_once "../auth/middleware.php";
require_once "../config/database.php";
require_once "../helpers/response.php";
 
if (!in_array($currentUser['role'], ['admin', 'petugas'])) {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

 
$db = (new Database())->connect();
 
$stmt = $db->prepare("
    SELECT u.id AS mahasiswa_id, u.username, k.nominal, k.status, p.jumlah_bayar, p.tanggal
    FROM users u
    LEFT JOIN ukt k ON u.id = k.mahasiswa_id
    LEFT JOIN pembayaran p ON k.id = p.ukt_id
    WHERE u.role = 'mahasiswa'
");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
jsonResponse($data);