<?php
require_once 'Sepatu.php';
class SepatuSport extends Sepatu
{
    private $jenisOlahraga;
    private $teknologi;
    private $beratGram;


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


    public function tampilInfo()
    {
        echo "===== SEPATU SPORT =====\n";
        parent::tampilInfo();
        echo "Jenis Olahraga : " . $this->jenisOlahraga . "\n";
        echo "Teknologi      : " . $this->teknologi . "\n";
        echo "Berat          : " . $this->beratGram . " gram\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }

    public function getKategori()
    {
        return "Sepatu Sport - " . $this->jenisOlahraga;
    }


    public function hitungDiskon($persen)
    {

        $totalDiskon = $persen + 5;
        $hargaDiskon = $this->harga - ($this->harga * $totalDiskon / 100);
        return $hargaDiskon;
    }
}
