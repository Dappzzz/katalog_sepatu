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
require_once 'classes/KeranjangBelanja.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT k.id_keranjang, k.qty, s.* FROM keranjang k 
          JOIN katalog_sepatu s ON k.id_sepatu = s.id 
          WHERE k.id_user = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang - ZXYAN Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-sm border-b border-gray-200 p-4 mb-8 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="bg-gray-900 text-white font-black text-xl md:text-2xl px-3 py-1 rounded tracking-widest shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                    ZXYAN
                </div>
                <span class="hidden md:inline-block font-semibold text-gray-600 tracking-wider text-sm uppercase">Footwear</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="hidden md:inline text-gray-600 text-sm">Halo, <b><?= $_SESSION['nama'] ?></b></span>
                <a href="process/logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600 transition text-sm">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4">
        <div class="bg-white p-6 md:p-10 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b-2 border-gray-100 pb-6">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🛒</span>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter" style="font-family: 'Montserrat', sans-serif;">Keranjang Saya</h2>
                </div>
                <a href="index.php" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2.5 rounded-lg font-bold transition text-sm">
                    <span>←</span> Kembali Belanja
                </a>
            </div>

            <form action="process/update_keranjang.php" method="POST">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-gray-400 uppercase text-xs tracking-widest font-bold">
                                <th class="py-4 px-2">Produk</th>
                                <th class="py-4 px-2 text-center">Harga</th>
                                <th class="py-4 px-2 text-center">Qty</th>
                                <th class="py-4 px-2 text-center">Subtotal</th>
                                <th class="py-4 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $total_belanja = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subtotal = $row['harga'] * $row['qty'];
                                $total_belanja += $subtotal;
                            ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-6 px-2">
                                        <div class="font-bold text-gray-900 text-lg"><?= $row['nama'] ?></div>
                                        <div class="text-xs text-gray-400 uppercase tracking-tighter"><?= $row['tipe_sepatu'] ?> • <?= $row['warna'] ?></div>
                                    </td>
                                    <td class="py-6 px-2 text-center font-medium">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td class="py-6 px-2 text-center">
                                        <input type="hidden" name="id_keranjang[]" value="<?= $row['id_keranjang'] ?>">
                                        <input type="number" name="qty[]" value="<?= $row['qty'] ?>" min="1" class="w-16 border-2 border-gray-100 rounded-lg text-center p-1 focus:border-gray-900 outline-none font-bold">
                                    </td>
                                    <td class="py-6 px-2 text-center font-black text-gray-900">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td class="py-6 px-2 text-center">
                                        <a href="process/hapus_item.php?id=<?= $row['id_keranjang'] ?>" class="text-red-400 hover:text-red-600 font-bold text-xs uppercase tracking-widest bg-red-50 hover:bg-red-100 px-3 py-2 rounded-md transition">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-center mt-8 pt-8 border-t-2 border-gray-50 gap-6">

                    <button type="submit" name="update_cart" class="group flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 hover:border-gray-900 hover:text-gray-900 px-6 py-3 rounded-xl font-bold transition uppercase tracking-widest text-xs w-full md:w-auto justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Perbarui Jumlah
                    </button>

                    <div class="text-right w-full md:w-auto bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <p class="text-gray-400 text-xs uppercase tracking-widest font-bold mb-1">Total Pembayaran</p>
                        <h3 class="text-4xl font-black text-gray-900 mb-6" style="font-family: 'Montserrat', sans-serif;">Rp <?= number_format($total_belanja, 0, ',', '.') ?></h3>
                        <a href="checkout.php" class="block w-full md:w-72 bg-gray-900 text-white text-center py-4 rounded-xl font-black text-lg hover:bg-gray-800 transition shadow-xl uppercase tracking-widest">
                            Checkout
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>