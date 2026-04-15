<?php
require_once 'Sepatu.php';
class SepatuCasual extends Sepatu
{
    private $gaya;
    private $material;
    private $edisiTerbatas; // bool

    // Konstruktor Level 3C
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
        $gaya,
        $material,
        $edisiTerbatas
    ) {
        parent::__construct($id, $nama, $harga, $deskripsi, $stok, $ukuran, $warna, $merek, $gender);
        $this->gaya          = $gaya;
        $this->material      = $material;
        $this->edisiTerbatas = $edisiTerbatas;
    }

    // Override tampilInfo() dari Sepatu
    public function tampilInfo()
    {
        echo "===== SEPATU CASUAL =====\n";
        parent::tampilInfo();
        echo "Gaya           : " . $this->gaya . "\n";
        echo "Material       : " . $this->material . "\n";
        echo "Edisi Terbatas : " . ($this->edisiTerbatas ? "Ya" : "Tidak") . "\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }

    // Override getKategori()
    public function getKategori()
    {
        $label = $this->edisiTerbatas ? "Sepatu Casual (Limited Edition)" : "Sepatu Casual";
        return $label;
    }

    // Override hitungDiskon() - Limited edition tidak boleh diskon
    public function hitungDiskon($persen)
    {
        if ($this->edisiTerbatas) {
            echo "  [INFO] Produk edisi terbatas tidak mendapat diskon.\n";
            return $this->harga;
        }
        return parent::hitungDiskon($persen);
    }
}
