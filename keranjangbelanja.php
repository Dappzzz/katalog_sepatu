<?php
require_once 'Produk.php';
class KeranjangBelanja
{
    private $items = [];
    private $namaPembeli;

    public function __construct($namaPembeli)
    {
        $this->namaPembeli = $namaPembeli;
    }

    public function tambahItem(Produk $produk, $qty)
    {
        if ($produk->getStok() < $qty) {
            echo "  [GAGAL] Stok " . $produk->getNama() . " tidak mencukupi!\n";
            return;
        }
        $this->items[] = ['produk' => $produk, 'qty' => $qty];
        echo "  [OK] " . $produk->getNama() . " x" . $qty . " ditambahkan ke keranjang.\n";
    }

    public function tampilKeranjang()
    {
        echo "\n========================================\n";
        echo "  KERANJANG BELANJA - " . strtoupper($this->namaPembeli) . "\n";
        echo "========================================\n";
        $total = 0;
        foreach ($this->items as $item) {
            $subtotal = $item['produk']->getHarga() * $item['qty'];
            $total   += $subtotal;
            echo "- " . $item['produk']->getNama()
                . " (" . $item['produk']->getKategori() . ")"
                . " x" . $item['qty']
                . " = Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        }
        echo "----------------------------------------\n";
        echo "TOTAL          : Rp " . number_format($total, 0, ',', '.') . "\n";
        echo "========================================\n\n";
        return $total;
    }

    public function checkout($metodePembayaran)
    {
        $total = $this->tampilKeranjang();
        echo "Metode Bayar   : " . $metodePembayaran . "\n";
        echo "Status         : PEMBAYARAN BERHASIL\n";
        echo "Terima kasih, " . $this->namaPembeli . "! Pesanan Anda sedang diproses.\n";
        echo "========================================\n\n";
    }
}
