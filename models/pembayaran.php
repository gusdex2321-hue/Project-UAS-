<?php

class Pembayaran
{
    private $conn;
    private $table = "pembayaran";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function bayar($ukt_id, $jumlah)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
            (ukt_id, jumlah_bayar, tanggal)
            VALUES (?, ?, NOW())"
        );
        return $stmt->execute([$ukt_id, $jumlah]);
    }
}