<?php

class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1"
        );
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create($username, $password, $role)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (username, password, role) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$username, $hash, $role]);
    }

    public function getAll()
    {
        return $this->conn
            ->query("SELECT id, username, role FROM {$this->table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT id, username, role FROM {$this->table} WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $role)
    {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET username = ?, role = ? WHERE id = ?"
        );
        return $stmt->execute([$username, $role, $id]);
    }

    public function updatePassword($id, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET password = ? WHERE id = ?"
        );
        return $stmt->execute([$hash, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}