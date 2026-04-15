<?php
require_once 'Produk.php';
class Sepatu extends Produk
{
    protected $ukuran;
    protected $warna;
    protected $merek;
    protected $gender; // Pria / Wanita / Unisex

    // Konstruktor Level 2 - memanggil parent::__construct()
    public function __construct($id, $nama, $harga, $deskripsi, $stok, $ukuran, $warna, $merek, $gender)
    {
        parent::__construct($id, $nama, $harga, $deskripsi, $stok);
        $this->ukuran = $ukuran;
        $this->warna  = $warna;
        $this->merek  = $merek;
        $this->gender = $gender;
    }

    // Override method tampilInfo() dari Produk
    public function tampilInfo()
    {
        parent::tampilInfo();
        echo "Merek       : " . $this->merek . "\n";
        echo "Ukuran      : " . $this->ukuran . "\n";
        echo "Warna       : " . $this->warna . "\n";
        echo "Gender      : " . $this->gender . "\n";
    }

    // Override getKategori()
    public function getKategori()
    {
        return "Sepatu";
    }

    // Override hitungDiskon() - tambah logika khusus sepatu
    public function hitungDiskon($persen)
    {
        $hargaDiskon = parent::hitungDiskon($persen);
        // Sepatu mendapat cashback Rp 10.000 setiap pembelian
        return $hargaDiskon - 10000;
    }

    public function getMerek()
    {
        return $this->merek;
    }

    public function getUkuran()
    {
        return $this->ukuran;
    }
}
