<?php
require "../auth/middleware.php";

// hanya admin
if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

jsonResponse([
    "message" => "Dashboard Admin Sistem Pembayaran UKT",
    "admin_id" => $currentUser['uid']
]);
