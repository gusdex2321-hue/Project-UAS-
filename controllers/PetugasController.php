<?php
require_once "../models/Petugas.php";
require_once "../helpers/response.php";

class PetugasController
{
    private $petugas;

    public function __construct($db)
    {
        $this->petugas = new Petugas($db);
    }

    public function index()
    {
        jsonResponse($this->petugas->getAll());
    }

    public function store($data)
    {
        if (!$data['nama'] || !$data['username'] || !$data['password']) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }

        $this->petugas->create(
            $data['nama'],
            $data['username'],
            $data['password'],
            $data['role'] ?? 'petugas'
        );

        jsonResponse(["message" => "Petugas berhasil ditambahkan"]);
    }

    public function update($id, $data)
    {
        $this->petugas->update(
            $id,
            $data['nama'],
            $data['username'],
            $data['role']
        );

        jsonResponse(["message" => "Petugas berhasil diupdate"]);
    }

    public function delete($id)
    {
        $this->petugas->delete($id);
        jsonResponse(["message" => "Petugas berhasil dihapus"]);
    }
}
