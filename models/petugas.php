<?php
class Petugas
{
    private $conn;
    private $table = "petugas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($nama, $username, $password, $role = 'petugas')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (nama, username, password, role) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nama, $username, $hash, $role]);
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT id, nama, username, role FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, nama, username, role FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nama, $username, $role)
    {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET nama = ?, username = ?, role = ? WHERE id = ?"
        );
        return $stmt->execute([$nama, $username, $role, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
