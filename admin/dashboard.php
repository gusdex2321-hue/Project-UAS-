<?php
require "../auth/middleware.php";


if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

jsonResponse([
    "message" => "Dashboard Admin Sistem Pembayaran UKT",
    "admin_id" => $currentUser['uid']
]);
