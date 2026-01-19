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
        $data
            ? jsonResponse($data)
            : jsonResponse(["message" => "User tidak ditemukan"], 404);
    }

    public function store($data)
    {
        if (!$data['username'] || !$data['password'] || !$data['role']) {
            jsonResponse(["message" => "Data tidak valid"], 422);
        }

        $this->user->create(
            $data['username'],
            $data['password'],
            $data['role']
        );

        jsonResponse(["message" => "User berhasil ditambahkan"]);
    }

    public function update($id, $data)
    {
        $this->user->update($id, $data['username'], $data['role']);
        jsonResponse(["message" => "User berhasil diperbarui"]);
    }

    public function updatePassword($id, $data)
    {
        $this->user->updatePassword($id, $data['password']);
        jsonResponse(["message" => "Password berhasil diubah"]);
    }

    public function destroy($id)
    {
        $this->user->delete($id);
        jsonResponse(["message" => "User berhasil dihapus"]);
    }
}
