<?php
 
class Mahasiswa
{
    private $conn;
    private $table = "mahasiswa";
 
    public function __construct($db)
    {
        $this->conn = $db;
    }
 
    public function getAll()
    {
        return $this->conn
            ->query("SELECT * FROM {$this->table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
 
    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public function create($nim, $nama, $prodi)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (nim, nama, prodi)
             VALUES (?, ?, ?)"
        );
        return $stmt->execute([$nim, $nama, $prodi]);
    }
}