<?php
require_once 'Sepatu.php';
class SepatuFormal extends Sepatu
{
    private $bahan;
    private $tinggiHak; // dalam cm
    private $sertifikasi; // misal: SNI, ISO

    // Konstruktor Level 3B
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

    // Override tampilInfo() dari Sepatu
    public function tampilInfo()
    {
        echo "===== SEPATU FORMAL =====\n";
        parent::tampilInfo();
        echo "Bahan          : " . $this->bahan . "\n";
        echo "Tinggi Hak     : " . $this->tinggiHak . " cm\n";
        echo "Sertifikasi    : " . $this->sertifikasi . "\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }

    // Override getKategori()
    public function getKategori()
    {
        return "Sepatu Formal";
    }

    // Override hitungDiskon() - Formal tidak dapat cashback, tapi ada cicilan 0%
    public function hitungDiskon($persen)
    {
        // Formal menggunakan diskon standar tanpa cashback tambahan
        return $this->harga - ($this->harga * $persen / 100);
    }

    public function infoCicilan($bulan)
    {
        $cicilan = $this->harga / $bulan;
        return "Cicilan " . $bulan . " bulan: Rp " . number_format($cicilan, 0, ',', '.');
    }
}
