<?php
 
class Database
{
    private $host = "localhost";
    private $port = "3307";
    private $db_name = "db_pembayarankampus";
    private $username = "root";
    private $password = "root";
 
    public function connect()
    {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
 
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }
}