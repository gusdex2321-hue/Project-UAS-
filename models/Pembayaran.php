<?php
class Pembayaran {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'db_kampus');
        if ($this->conn->connect_error) die('Koneksi gagal: '.$this->conn->connect_error);
    }

    public function getAll() {
        $sql = "SELECT * FROM pembayaran_ukt ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertPembayaran($nim, $nama, $semester, $jumlah, $bukti) {
        $status = 'Menunggu Verifikasi';
        $stmt = $this->conn->prepare(
            "INSERT INTO pembayaran_ukt (nim, nama, semester, jumlah, bukti, status) VALUES (?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssiss', $nim, $nama, $semester, $jumlah, $bukti, $status);
        return $stmt->execute();
    }
}
