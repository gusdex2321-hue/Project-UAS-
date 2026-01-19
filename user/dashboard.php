<?php
require "../auth/middleware.php";

jsonResponse([
    "message" => "Dashboard Mahasiswa",
    "mahasiswa_id" => $currentUser['uid'],
    "role" => $currentUser['role']
]);