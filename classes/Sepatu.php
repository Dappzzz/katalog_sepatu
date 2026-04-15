<?php
require_once 'Produk.php';
class Sepatu extends Produk
{
    protected $ukuran;
    protected $warna;
    protected $merek;
    protected $gender;

    public function __construct($id, $nama, $harga, $deskripsi, $stok, $ukuran, $warna, $merek, $gender)
    {
        parent::__construct($id, $nama, $harga, $deskripsi, $stok);
        $this->ukuran = $ukuran;
        $this->warna  = $warna;
        $this->merek  = $merek;
        $this->gender = $gender;
    }


    public function tampilInfo()
    {
        parent::tampilInfo();
        echo "Merek       : " . $this->merek . "\n";
        echo "Ukuran      : " . $this->ukuran . "\n";
        echo "Warna       : " . $this->warna . "\n";
        echo "Gender      : " . $this->gender . "\n";
    }


    public function getKategori()
    {
        return "Sepatu";
    }


    public function hitungDiskon($persen)
    {
        $hargaDiskon = parent::hitungDiskon($persen);

        return $hargaDiskon - 10000;
    }

    public function getWarna()
    {
        return $this->warna;
    }

    public function getUkuran()
    {
        return $this->ukuran;
    }

    public function getMerek()
    {
        return $this->merek;
    }
}
