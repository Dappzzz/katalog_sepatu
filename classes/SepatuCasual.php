<?php
require_once 'Sepatu.php';
class SepatuCasual extends Sepatu
{
    private $gaya;
    private $material;
    private $edisiTerbatas; 


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


    public function tampilInfo()
    {
        echo "===== SEPATU CASUAL =====\n";
        parent::tampilInfo();
        echo "Gaya           : " . $this->gaya . "\n";
        echo "Material       : " . $this->material . "\n";
        echo "Edisi Terbatas : " . ($this->edisiTerbatas ? "Ya" : "Tidak") . "\n";
        echo "Kategori       : " . $this->getKategori() . "\n";
    }


    public function getKategori()
    {
        $label = $this->edisiTerbatas ? "Sepatu Casual (Limited Edition)" : "Sepatu Casual";
        return $label;
    }


    public function hitungDiskon($persen)
    {
        if ($this->edisiTerbatas) {
            echo "  [INFO] Produk edisi terbatas tidak mendapat diskon.\n";
            return $this->harga;
        }
        return parent::hitungDiskon($persen);
    }
}
