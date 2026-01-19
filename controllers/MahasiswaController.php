<?php
require "../models/Mahasiswa.php";
require "../helpers/response.php";

class MahasiswaController
{
    private $mahasiswa;

    public function __construct($db)
    {
        $this->mahasiswa = new Mahasiswa($db);
    }

    public function index()
    {
        jsonResponse($this->mahasiswa->getAll());
    }

    public function store($data)
    {
        if (!$data['nim'] || !$data['nama'] || !$data['prodi']) {
            jsonResponse(["message" => "Data tidak lengkap"], 422);
        }

        $this->mahasiswa->create(
            $data['nim'],
            $data['nama'],
            $data['prodi']
        );

        jsonResponse(["message" => "Mahasiswa berhasil ditambahkan"]);
    }
}