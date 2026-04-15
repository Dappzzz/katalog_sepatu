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

$user_id = $_SESSION['user_id'];
$query = "SELECT k.qty, s.* FROM keranjang k JOIN katalog_sepatu s ON k.id_sepatu = s.id WHERE k.id_user = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout - ZXYAN Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans pb-20">

    <nav class="bg-white shadow-sm border-b border-gray-200 p-4 mb-8 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="bg-gray-900 text-white font-black text-xl md:text-2xl px-3 py-1 rounded tracking-widest shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                    ZXYAN
                </div>
                <span class="hidden md:inline-block font-semibold text-gray-600 tracking-wider text-sm uppercase">Footwear</span>
            </a>
            <div class="text-gray-400 text-xs font-bold uppercase tracking-widest hidden md:block">Proses Checkout</div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-12 gap-10">

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-black text-gray-900 mb-8 uppercase tracking-tight" style="font-family: 'Montserrat', sans-serif;">Detail Pengiriman</h2>
                <form action="process/proses_checkout.php" method="POST" id="form-checkout" class="space-y-6">
                    <div>
                        <label class="block text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Nama Penerima</label>
                        <input type="text" value="<?= $_SESSION['nama'] ?>" disabled class="w-full px-4 py-3 border-2 border-gray-50 rounded-xl bg-gray-50 text-gray-500 font-bold">
                    </div>
                    <div>
                        <label class="block text-gray-900 text-xs font-bold uppercase tracking-widest mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" required rows="3" class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl focus:border-gray-900 outline-none transition" placeholder="Masukkan alamat pengiriman..."></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-900 text-xs font-bold uppercase tracking-widest mb-2">Metode Pembayaran</label>
                        <select name="metode" required class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl focus:border-gray-900 outline-none transition font-bold text-gray-700">
                            <option value="BCA Transfer">BCA Transfer</option>
                            <option value="Mandiri Virtual Account">Mandiri Virtual Account</option>
                            <option value="E-Wallet (GoPay/OVO)">E-Wallet (GoPay/OVO)</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100 sticky top-28">
                <h2 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight" style="font-family: 'Montserrat', sans-serif;">Ringkasan Pesanan</h2>
                <div class="space-y-5 mb-8"> <?php
                                                $total = 0;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $sub = $row['harga'] * $row['qty'];
                                                    $total += $sub;
                        
                                                    echo "<div class='flex flex-wrap justify-between items-center text-sm gap-2'>";
                                                    echo "<span class='text-gray-500 font-medium flex-1 min-w-[60%]'>{$row['qty']}x {$row['nama']}</span>";
                                                    echo "<span class='font-bold text-gray-900 whitespace-nowrap text-right'>Rp " . number_format($sub, 0, ',', '.') . "</span>";
                                                    echo "</div>";
                                                }
                                                ?>
                </div>

                <div class="border-t-2 border-gray-50 pt-6 mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Tagihan</span>
                        <span class="text-3xl font-black text-gray-900" style="font-family: 'Montserrat', sans-serif;">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                </div>

                <button onclick="document.getElementById('form-checkout').submit()" class="w-full bg-gray-900 text-white font-black py-4 rounded-xl hover:bg-gray-800 transition shadow-lg uppercase tracking-widest text-lg">
                    Bayar Sekarang
                </button>
                <p class="text-xs text-gray-400 text-center mt-5 italic px-4">Dengan mengklik tombol di atas, Anda menyetujui syarat & ketentuan ZXYAN Footwear.</p>
            </div>
        </div>
    </div>
</body>

</html>