<?php
class Produk   
{
    protected $id;
    protected $nama;
    protected $harga;
    protected $deskripsi;
    protected $stok;


    public function __construct($id, $nama, $harga, $deskripsi, $stok)
    {
        $this->id        = $id;
        $this->nama      = $nama;
        $this->harga     = $harga;
        $this->deskripsi = $deskripsi;
        $this->stok      = $stok;
    }


    public function tampilInfo()
    {
        echo "===== INFORMASI PRODUK =====\n";
        echo "ID Produk   : " . $this->id . "\n";
        echo "Nama        : " . $this->nama . "\n";
        echo "Harga       : Rp " . number_format($this->harga, 0, ',', '.') . "\n";
        echo "Deskripsi   : " . $this->deskripsi . "\n";
        echo "Stok        : " . $this->stok . " pcs\n";
    }

    public function hitungDiskon($persen)
    {
        return $this->harga - ($this->harga * $persen / 100);
    }

    public function getKategori()
    {
        return "Produk Umum";
    }

    public function getHarga()
    {
        return $this->harga;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getStok()
    {
        return $this->stok;
    }

    public function getId()
    {
        return $this->id;
    }
}
