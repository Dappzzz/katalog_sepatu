<?php
require_once 'Produk.php';
class KatalogToko

{
    private $produkList = [];
    private $namaToko;

    public function __construct($namaToko)
    {
        $this->namaToko = $namaToko;
    }

    public function tambahProduk(Produk $produk)
    {
        $this->produkList[$produk->getId()] = $produk;
    }

    public function tampilKatalog()
    {
        echo "\n";

        echo "║   KATALOG TOKO: " . strtoupper($this->namaToko) . str_repeat(" ", 26 - strlen($this->namaToko)) . "║\n";

        foreach ($this->produkList as $produk) {
            $produk->tampilInfo();
            echo "\n";
        }
    }

    public function cariProduk($id)
    {
        return isset($this->produkList[$id]) ? $this->produkList[$id] : null;
    }

    public function tampilDiskon($persen)
    {
        echo "\n===== PROMO DISKON " . $persen . "% =====\n";
        foreach ($this->produkList as $produk) {
            $hargaSetelah = $produk->hitungDiskon($persen);
            echo $produk->getNama()
                . " | Harga awal: Rp " . number_format($produk->getHarga(), 0, ',', '.')
                . " => Setelah diskon: Rp " . number_format($hargaSetelah, 0, ',', '.') . "\n";
        }
        echo "\n";
    }
    public function getProdukList()
    {
        return $this->produkList;
    }
}
