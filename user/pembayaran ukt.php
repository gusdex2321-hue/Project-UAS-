<?php
session_start();
require_once '../controllers/PembayaranController.php';

$controller = new PembayaranController();
$dataPembayaran = $controller->getPembayaran();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran UKT</title>
</head>
<body>
<h2>Pembayaran UKT Mahasiswa</h2>

<form method="post" action="../controllers/PembayaranController.php" enctype="multipart/form-data">
    NIM: <input type="text" name="nim" placeholder="Opsional"><br><br>
    Nama: <input type="text" name="nama" placeholder="Opsional"><br><br>
    Semester: <input type="text" name="semester" required><br><br>
    Jumlah UKT: <input type="number" name="jumlah" required><br><br>
    Bukti Pembayaran: <input type="file" name="bukti" required><br><br>
    <button type="submit" name="upload">Upload</button>
</form>

<hr>

<table border="1" cellpadding="5">
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Semester</th>
        <th>Jumlah</th>
        <th>Bukti</th>
        <th>Status</th>
    </tr>
    <?php foreach ($dataPembayaran as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['nim']) ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['semester']) ?></td>
        <td><?= htmlspecialchars($row['jumlah']) ?></td>
        <td><?= htmlspecialchars($row['bukti']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
