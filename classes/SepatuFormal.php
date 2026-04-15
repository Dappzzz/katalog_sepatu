<?php
require_once 'Sepatu.php';
class SepatuFormal extends Sepatu
{
    private $bahan;
    private $tinggiHak; 
    private $sertifikasi;


    public function __construct(
        $id,
        $nama,
        $harga,
        $deskripsi,
        $stok,
        $ukuran,
        $warna,
        $merek,
        $gender,
        $bahan,
        $tinggiHak,
        $sertifikasi
    ) {
        parent::__construct($id, $nama, $harga, $deskripsi, $stok, $ukuran, $warna, $merek, $gender);
        $this->bahan        = $bahan;
        $this->tinggiHak    = $tinggiHak;
        $this->sertifikasi  = $sertifikasi;
    }


    public function tampilInfo()
    {
        echo "===== SEPATU FORMAL =====\n";
        parent::tampilInfo();
        echo "Bahan          : " . $this->bahan . "\n";
        echo "Tinggi Hak     : " . $this->tinggiHak . " cm\n";
        echo "Sertifikasi    : " . $this->sertifikasi . "\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }


    public function getKategori()
    {
        return "Sepatu Formal";
    }


    public function hitungDiskon($persen)
    {

        return $this->harga - ($this->harga * $persen / 100);
    }

    public function infoCicilan($bulan)
    {
        $cicilan = $this->harga / $bulan;
        return "Cicilan " . $bulan . " bulan: Rp " . number_format($cicilan, 0, ',', '.');
    }
}
