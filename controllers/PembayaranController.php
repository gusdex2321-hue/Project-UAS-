<?php
require "../models/Pembayaran.php";
require "../models/UKT.php";
require "../helpers/response.php";

class PembayaranController
{
    private $pembayaran;
    private $ukt;

    public function __construct($db)
    {
        $this->pembayaran = new Pembayaran($db);
        $this->ukt = new UKT($db);
    }

    public function bayar($mahasiswa_id, $data)
    {
        $ukt = $this->ukt->getByMahasiswa($mahasiswa_id);

        if (!$ukt) {
            jsonResponse(["message" => "Tagihan UKT tidak ditemukan"], 404);
        }

        $this->pembayaran->bayar($ukt['id'], $data['jumlah']);
        $this->ukt->updateStatus($mahasiswa_id);

        jsonResponse(["message" => "Pembayaran UKT berhasil"]);
    }
}
