<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';


require_once 'classes/SepatuSport.php';
require_once 'classes/SepatuFormal.php';
require_once 'classes/SepatuCasual.php';
require_once 'classes/KatalogToko.php';

$toko = new KatalogToko("ZXYAN Footwear");


$result = mysqli_query($conn, "SELECT * FROM katalog_sepatu");

while ($row = mysqli_fetch_assoc($result)) {

    if ($row['tipe_sepatu'] == 'Sport') {
        $sepatu = new SepatuSport($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['jenis_olahraga'], $row['teknologi'], $row['berat_gram']);
    } elseif ($row['tipe_sepatu'] == 'Formal') {
        $sepatu = new SepatuFormal($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['bahan'], $row['tinggi_hak'], $row['sertifikasi']);
    } elseif ($row['tipe_sepatu'] == 'Casual') {
        $sepatu = new SepatuCasual($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['gaya'], $row['material'], $row['edisi_terbatas']);
    }
    
    if(isset($sepatu)) { 
        $toko->tambahProduk($sepatu); 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog - ZXYAN Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans pb-20">

    <nav class="bg-white shadow-sm border-b border-gray-200 p-4 mb-8 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <a href="index.php" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="bg-gray-900 text-white font-black text-xl md:text-2xl px-3 py-1 rounded tracking-widest shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                    ZXYAN
                </div>
                <span class="hidden md:inline-block font-semibold text-gray-600 tracking-wider text-sm uppercase">Footwear</span>
            </a>

            <div class="flex items-center gap-4 md:gap-6">
                <div class="hidden md:block text-gray-600 text-sm">
                    Halo, <span class="font-bold text-gray-900"><?= $_SESSION['nama'] ?></span>
                </div>
                
                <a href="keranjang.php" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-bold transition border border-gray-300">
                    🛒 <span class="hidden md:inline">Keranjang</span>
                </a>
                
                <a href="process/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600 transition shadow-sm">
                    Keluar
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mb-8">
        <h2 class="text-3xl font-black text-gray-900 mb-2 uppercase tracking-wide">New Arrivals</h2>
        <p class="text-gray-500">Temukan koleksi sepatu premium terbaru untuk melengkapi gayamu.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php

        $daftar_sepatu = $toko->getProdukList(); 
        
        foreach ($daftar_sepatu as $item) {
            /** @var Sepatu $item */
            

            $badgeColor = "bg-gray-200 text-gray-700";
            if ($item->getKategori() == "Sport") $badgeColor = "bg-blue-100 text-blue-800";
            if ($item->getKategori() == "Formal") $badgeColor = "bg-gray-900 text-gray-100";
            if ($item->getKategori() == "Casual") $badgeColor = "bg-green-100 text-green-800";

            echo "<div class='bg-white p-5 rounded-xl shadow border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col h-full'>";
            
            // Kategori Badge & ID
            echo "<div class='flex justify-between items-start mb-3'>";
            echo "<span class='inline-block $badgeColor text-xs px-2 py-1 rounded font-bold uppercase tracking-wider'>" . $item->getKategori() . "</span>";
            echo "<span class='text-xs text-gray-400 font-mono'>" . $item->getId() . "</span>";
            echo "</div>";
            
            // Nama Produk
            echo "<h3 class='text-lg font-bold text-gray-900 leading-tight mb-2 flex-grow'>" . $item->getNama() . "</h3>";
            
            // Harga
            echo "<div class='text-xl text-gray-900 font-black mb-4'>Rp " . number_format($item->getHarga(), 0, ',', '.') . "</div>";
            
            // Spesifikasi Singkat
            echo "<div class='bg-gray-50 p-3 rounded-lg text-xs text-gray-600 mb-5 space-y-1 border border-gray-100'>";
            echo "<p><span class='font-bold text-gray-800'>Merek:</span> " . $item->getMerek() . "</p>";
            echo "<p><span class='font-bold text-gray-800'>Warna:</span> " . $item->getWarna() . "</p>";
            echo "<p><span class='font-bold text-gray-800'>Ukuran:</span> " . $item->getUkuran() . "</p>";
            

            if ($item->getStok() < 15) {
                echo "<p><span class='font-bold text-gray-800'>Stok:</span> <span class='text-red-500 font-bold'>Sisa " . $item->getStok() . " pcs!</span></p>";
            } else {
                echo "<p><span class='font-bold text-gray-800'>Stok:</span> " . $item->getStok() . " pcs</p>";
            }
            echo "</div>";
            

            echo "<div class='mt-auto'>"; 
            echo "<a href='process/tambah_keranjang.php?id=" . $item->getId() . "' class='block w-full text-center bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-700 transition uppercase tracking-widest text-sm shadow-md'>Tambah</a>";
            echo "</div>";

            echo "</div>";
        }
        ?>
    </div>

</body>
</html>