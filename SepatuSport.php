<?php
require_once 'Sepatu.php';
class SepatuSport extends Sepatu
{
    private $jenisOlahraga;
    private $teknologi;
    private $beratGram;

    // Konstruktor Level 3A
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
        $jenisOlahraga,
        $teknologi,
        $beratGram
    ) {
        parent::__construct($id, $nama, $harga, $deskripsi, $stok, $ukuran, $warna, $merek, $gender);
        $this->jenisOlahraga = $jenisOlahraga;
        $this->teknologi     = $teknologi;
        $this->beratGram     = $beratGram;
    }

    // Override tampilInfo() dari Sepatu
    public function tampilInfo()
    {
        echo "===== SEPATU SPORT =====\n";
        parent::tampilInfo();
        echo "Jenis Olahraga : " . $this->jenisOlahraga . "\n";
        echo "Teknologi      : " . $this->teknologi . "\n";
        echo "Berat          : " . $this->beratGram . " gram\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }

    // Override getKategori()
    public function getKategori()
    {
        return "Sepatu Sport - " . $this->jenisOlahraga;
    }

    // Override hitungDiskon() - Sport dapat diskon lebih besar
    public function hitungDiskon($persen)
    {
        // Sport mendapat bonus diskon tambahan 5%
        $totalDiskon = $persen + 5;
        $hargaDiskon = $this->harga - ($this->harga * $totalDiskon / 100);
        return $hargaDiskon;
    }
}
