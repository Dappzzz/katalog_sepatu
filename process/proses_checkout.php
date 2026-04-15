<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['alamat'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$alamat = $_POST['alamat'];
$metode = $_POST['metode'];


$query_keranjang = "SELECT k.qty, s.id, s.harga FROM keranjang k 
                    JOIN katalog_sepatu s ON k.id_sepatu = s.id 
                    WHERE k.id_user = '$user_id'";
$result_keranjang = mysqli_query($conn, $query_keranjang);

$total_bayar = 0;
$items = []; 

while ($row = mysqli_fetch_assoc($result_keranjang)) {
    $subtotal = $row['harga'] * $row['qty'];
    $total_bayar += $subtotal;


    $items[] = [
        'id_sepatu' => $row['id'],
        'harga' => $row['harga'],
        'qty' => $row['qty'],
        'subtotal' => $subtotal
    ];
}

$query_transaksi = "INSERT INTO transaksi (id_user, alamat_pengiriman, metode_pembayaran, total_bayar) 
                    VALUES ('$user_id', '$alamat', '$metode', '$total_bayar')";
mysqli_query($conn, $query_transaksi);


$id_transaksi_baru = mysqli_insert_id($conn);


foreach ($items as $item) {
    $id_sepatu = $item['id_sepatu'];
    $harga = $item['harga'];
    $qty = $item['qty'];
    $subtotal = $item['subtotal'];

    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_sepatu, harga_satuan, qty, subtotal) 
                         VALUES ('$id_transaksi_baru', '$id_sepatu', '$harga', '$qty', '$subtotal')");
}

// 4. BERSIHKAN KERANJANG!
mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$user_id'");

// 5. Arahkan ke halaman Sukses
header("Location: ../sukses.php?id_trx=" . $id_transaksi_baru);
exit();
