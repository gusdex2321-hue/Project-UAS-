<?php

class UKT
{
    private $conn;
    private $table = "ukt";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setUKT($mahasiswa_id, $nominal)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
            (mahasiswa_id, nominal, status)
            VALUES (?, ?, 'belum lunas')"
        );
        return $stmt->execute([$mahasiswa_id, $nominal]);
    }

    public function getByMahasiswa($mahasiswa_id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table}
             WHERE mahasiswa_id = ?"
        );
        $stmt->execute([$mahasiswa_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($mahasiswa_id)
    {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET status = 'lunas'
             WHERE mahasiswa_id = ?"
        );
        return $stmt->execute([$mahasiswa_id]);
    }
}