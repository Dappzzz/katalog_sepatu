<?php
session_start();
include 'config.php';

// Panggil semua class
require_once 'SepatuSport.php';
require_once 'SepatuFormal.php';
require_once 'SepatuCasual.php';
require_once 'KeranjangBelanja.php';

if (!isset($_SESSION['session_id'])) {
    die("Keranjang kosong. <a href='index.php'>Belanja dulu yuk!</a>");
}

$session_id = $_SESSION['session_id'];
$keranjang = new KeranjangBelanja("User"); // Objek Keranjang

// 1. Ambil data keranjang JOIN katalog_sepatu
$query = "SELECT k.id_keranjang, k.qty, s.* FROM keranjang k 
          JOIN katalog_sepatu s ON k.id_sepatu = s.id 
          WHERE k.session_id = '$session_id'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f4f7f6;
            padding: 20px;
        }

        .cart-container {
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-update {
            background: #3498db;
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-checkout {
            background: #2ecc71;
            display: block;
            text-align: center;
            font-size: 1.2em;
            padding: 15px;
            margin-top: 20px;
        }

        .qty-input {
            width: 50px;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="cart-container">
        <h2>🛒 Keranjang Belanja Anda</h2>
        <a href="index.php">← Kembali</a>
        <br><br>

        <form action="update_keranjang.php" method="POST">
            <table>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>

                <?php
                $total_belanja = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    // 2. Instansiasi Objek PBO
                    if ($row['tipe_sepatu'] == 'Sport') {
                        $sepatu = new SepatuSport($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['jenis_olahraga'], $row['teknologi'], $row['berat_gram']);
                    } elseif ($row['tipe_sepatu'] == 'Formal') {
                        $sepatu = new SepatuFormal($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['bahan'], $row['tinggi_hak'], $row['sertifikasi']);
                    } elseif ($row['tipe_sepatu'] == 'Casual') {
                        $sepatu = new SepatuCasual($row['id'], $row['nama'], $row['harga'], $row['deskripsi'], $row['stok'], $row['ukuran'], $row['warna'], $row['merek'], $row['gender'], $row['gaya'], $row['material'], $row['edisi_terbatas']);
                    }

                    // Masukkan ke Objek Keranjang (opsional, jika method tampilKeranjang() milikmu sudah menangani UI)
                    // $keranjang->tambahItem($sepatu, $row['qty']); 

                    // Hitung Subtotal pakai method PBO
                    $subtotal = $sepatu->getHarga() * $row['qty'];
                    $total_belanja += $subtotal;

                    echo "<tr>";
                    echo "<td><b>" . $sepatu->getNama() . "</b></td>";
                    echo "<td>" . $sepatu->getKategori() . "</td>";
                    echo "<td>Rp " . number_format($sepatu->getHarga(), 0, ',', '.') . "</td>";

                    // Form Update Qty (array input)
                    echo "<td>
                        <input type='hidden' name='id_keranjang[]' value='" . $row['id_keranjang'] . "'>
                        <input type='number' name='qty[]' value='" . $row['qty'] . "' min='1' max='" . $sepatu->getStok() . "' class='qty-input'>
                      </td>";

                    echo "<td><b>Rp " . number_format($subtotal, 0, ',', '.') . "</b></td>";
                    echo "<td><a href='hapus_item.php?id=" . $row['id_keranjang'] . "' class='btn btn-delete'>Hapus</a></td>";
                    echo "</tr>";
                }
                ?>

            </table>

            <div style="text-align: right; margin-top: 20px;">
                <h3>Total: Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></h3>
                <button type="submit" name="update_cart" class="btn btn-update">Simpan Perubahan Qty</button>
            </div>
        </form>

        <a href="#" class="btn btn-checkout">Checkout</a>

    </div>
</body>

</html>