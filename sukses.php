<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['id_trx'])) {
    header("Location: index.php");
    exit();
}

include 'config.php';
$id_trx = $_GET['id_trx'];
$user_id = $_SESSION['user_id'];

// Ambil data transaksi untuk verifikasi
$query = "SELECT * FROM transaksi WHERE id_transaksi = '$id_trx' AND id_user = '$user_id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Berhasil - ZXYAN Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 h-screen flex flex-col font-sans">

    <nav class="bg-white shadow-sm border-b border-gray-200 p-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-center items-center">
            <a href="index.php" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="bg-gray-900 text-white font-black text-xl md:text-2xl px-3 py-1 rounded tracking-widest shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                    ZXYAN
                </div>
                <span class="hidden md:inline-block font-semibold text-gray-600 tracking-wider text-sm uppercase">Footwear</span>
            </a>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border border-gray-100 max-w-lg w-full text-center">

            <div class="w-24 h-24 bg-gray-900 text-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-3xl font-black text-gray-900 mb-2 uppercase tracking-tight" style="font-family: 'Montserrat', sans-serif;">Pesanan Berhasil!</h1>
            <p class="text-gray-500 mb-8 text-sm">Terima kasih, pesanan Anda telah masuk ke sistem kami dan akan segera diproses.</p>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200 text-left">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Nomor Invoice</span>
                    <span class="font-black text-gray-900 text-lg">#INV-<?= str_pad($data['id_transaksi'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Metode Bayar</span>
                    <span class="font-bold text-gray-700"><?= $data['metode_pembayaran'] ?></span>
                </div>
                <div class="flex justify-between items-center border-t-2 border-gray-200 pt-4 mt-2">
                    <span class="text-gray-900 text-xs font-bold uppercase tracking-widest">Total Tagihan</span>
                    <span class="font-black text-gray-900 text-2xl" style="font-family: 'Montserrat', sans-serif;">Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></span>
                </div>
            </div>

            <div class="space-y-4">
                <a href="index.php" class="block w-full bg-gray-900 text-white font-black py-4 rounded-xl hover:bg-gray-800 transition shadow-lg uppercase tracking-widest text-sm">
                    Kembali ke Katalog
                </a>
                <p class="text-[10px] text-gray-400 italic mt-4">Silakan screenshot halaman ini sebagai bukti transaksi Anda.</p>
            </div>

        </div>
    </div>

</body>

</html>