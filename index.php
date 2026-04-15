<?php
// 1. Panggil Koneksi & Autoloader/Class
include 'config.php';
require_once 'SepatuSport.php';
require_once 'SepatuFormal.php';
require_once 'SepatuCasual.php';
require_once 'KatalogToko.php';

$toko = new KatalogToko("ShoesStore.ID");

// 2. AMBIL DATA DARI MYSQL DAN UBAH MENJADI OBJEK PBO
$result = mysqli_query($conn, "SELECT * FROM katalog_sepatu");

while ($row = mysqli_fetch_assoc($result)) {
    // Mengecek tipe sepatu dari database untuk memanggil Class yang tepat
    if ($row['tipe_sepatu'] == 'Sport') {
        $sepatu = new SepatuSport($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['jenis_olahraga'], $row['teknologi'], $row['berat_gram']);
    } elseif ($row['tipe_sepatu'] == 'Formal') {
        $sepatu = new SepatuFormal($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['bahan'], $row['tinggi_hak'], $row['sertifikasi']);
    } elseif ($row['tipe_sepatu'] == 'Casual') {
        $sepatu = new SepatuCasual($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['gaya'], $row['material'], $row['edisi_terbatas']);
    }

    // Masukkan objek yang sudah jadi ke dalam Toko
    if (isset($sepatu)) {
        $toko->tambahProduk($sepatu);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>ShoesStore.ID - Katalog Interaktif</title>
    <style>
        /* CSS INTERAKTIF & MODERN */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ce865f;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 5px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1em;
        }

        /* Layout Grid untuk Kartu Produk */
        .katalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Desain Kartu Interaktif */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 5px solid #3498db;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        /* Elemen dalam Kartu */
        .kategori-badge {
            display: inline-block;
            background: #e8f4f8;
            color: #2980b9;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .nama-produk {
            font-size: 1.4em;
            color: #333;
            margin: 0 0 10px 0;
        }

        .harga {
            font-size: 1.5em;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .spesifikasi {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.9em;
            color: #555;
            line-height: 1.6;
        }

        .spesifikasi b {
            color: #333;
        }

        .btn-beli {
            display: block;
            width: 100%;
            text-align: center;
            background: #2ecc71;
            color: white;
            padding: 12px 0;
            margin-top: 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-beli:hover {
            background: #27ae60;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Zxyanntore.ID</h1>
        <p>Katalog Sepatu Premium - Gaya Keren, Harga Bersahabat</p>
    </div>

    <div class="katalog-grid">
        <?php
        // 3. RENDER HTML DARI OBJEK PBO
        // Kita mengambil array produk dari dalam class KatalogToko menggunakan refleksi atau metode get.
        // Asumsi: Kamu perlu menambahkan method getProdukList() di class KatalogToko.

        // (NOTE: Di file KatalogToko.php mu, pastikan ada fungsi ini:
        // public function getProdukList() { return $this->produkList; } )

        $daftar_sepatu = $toko->getProdukList();

        foreach ($daftar_sepatu as $item) {
            /** @var Sepatu $item */  // <-- TAMBAHKAN BARIS INI

            echo "<div class='card'>";

            // Menggunakan method bawaan objek (Polymorphism)
            echo "<span class='kategori-badge'>" . $item->getKategori() . "</span>";
            echo "<h2 class='nama-produk'>" . $item->getNama() . "</h2>";
            echo "<div class='harga'>Rp " . number_format($item->getHarga(), 0, ',', '.') . "</div>";

            echo "<div class='spesifikasi'>";
            echo "<b>Merek:</b> " . $item->getMerek() . "<br>";
            echo "<b>Ukuran:</b> " . $item->getUkuran() . "<br>";
            echo "<b>Stok:</b> " . $item->getStok() . " pcs<br>";

            // Pengecekan tipe spesifik menggunakan instanceOf (Fitur PBO)
            if ($item instanceof SepatuSport) {
                // (Kamu perlu menambahkan getter di SepatuSport untuk olahraga, dll)
                echo "<i>Cocok untuk aktivitas berat dan lari.</i>";
            } elseif ($item instanceof SepatuFormal) {
                echo "<i>Desain elegan untuk acara resmi.</i>";
            }

            echo "</div>";

            echo "<a href='tambah_keranjang.php?id=" . $item->getId() . "' class='btn-beli'>Tambah ke Keranjang</a>";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>