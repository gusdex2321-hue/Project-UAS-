<?php
require "../auth/middleware.php";

if (!in_array($currentUser['role'], ['admin','petugas'])) {
    jsonResponse(["message" => "Akses ditolak"], 403);
}

jsonResponse([
    "message" => "Dashboard Petugas Keuangan UKT",
    "user_id" => $currentUser['uid'],
    "role" => $currentUser['role']
]);
