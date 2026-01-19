<?php
require_once '../models/Pembayaran.php';

class PembayaranController {
    private $model;

    public function __construct() {
        $this->model = new Pembayaran();
    }

    public function getPembayaran() {
        return $this->model->getAll();
    }

    public function uploadPembayaran($data, $file) {
        $nim = $data['nim'] ?? '';   // bisa kosong
        $nama = $data['nama'] ?? ''; // bisa kosong
        $namaFile = time().'_'.$file['name'];
        move_uploaded_file($file['tmp_name'], '../uploads/'.$namaFile);

        return $this->model->insertPembayaran(
            $nim,
            $nama,
            $data['semester'],
            $data['jumlah'],
            $namaFile
        );
    }
}

if (isset($_POST['upload'])) {
    $controller = new PembayaranController();
    $controller->uploadPembayaran($_POST, $_FILES['bukti']);
    header('Location: ../user/pembayaran.php');
}
