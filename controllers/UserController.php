<?php
require_once "../models/User.php";
require_once "../helpers/response.php";

class UserController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    

    public function index()
    {
        jsonResponse($this->user->getAll());
    }

    public function show($id)
    {
        $data = $this->user->getById($id);
        if (!$data) {
            jsonResponse(["message" => "User tidak ditemukan"], 404);
        }

        jsonResponse($data);
    }

    

    public function store($data)
    {
        if (
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['role'])
        ) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }

        
        $allowedRoles = ['admin', 'petugas', 'mahasiswa'];
        if (!in_array($data['role'], $allowedRoles)) {
            jsonResponse(["message" => "Role tidak valid"], 422);
        }

        
        if ($this->user->findByUsername($data['username'])) {
            jsonResponse(["message" => "Username sudah digunakan"], 409);
        }

        $this->user->create(
            $data['username'],
            $data['password'],
            $data['role']
        );

        jsonResponse(["message" => "User berhasil ditambahkan"], 201);
    }

    

    public function update($id, $data)
    {
        $existing = $this->user->getById($id);
        if (!$existing) {
            jsonResponse(["message" => "User tidak ditemukan"], 404);
        }

        
        $username = $data['username'] ?? $existing['username'];
        $role = $data['role'] ?? $existing['role'];

        
        $allowedRoles = ['admin', 'petugas', 'mahasiswa'];
        if (!in_array($role, $allowedRoles)) {
            jsonResponse(["message" => "Role tidak valid"], 422);
        }

        
        $userByUsername = $this->user->findByUsername($username);
        if ($userByUsername && $userByUsername['id'] != $id) {
            jsonResponse(["message" => "Username sudah digunakan"], 409);
        }

        $this->user->update($id, $username, $role);
    }

    

    public function updatePassword($id, $data)
    {
        if (empty($data['password'])) {
            jsonResponse(["message" => "Password wajib diisi"], 422);
        }

        $existing = $this->user->getById($id);
        if (!$existing) {
            jsonResponse(["message" => "User tidak ditemukan"], 404);
        }

        $this->user->updatePassword($id, $data['password']);
    }

    

    public function destroy($id)
    {
        $existing = $this->user->getById($id);
        if (!$existing) {
            jsonResponse(["message" => "User tidak ditemukan"], 404);
        }

        $this->user->delete($id);
        jsonResponse(["message" => "User berhasil dihapus"]);
    }
}
