<?php
session_start();
include 'config.php';

// Cek apakah user sudah login (jika belum, buat session ID sementara)
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id(); 
}

$id_sepatu = $_GET['id'];
$session_id = $_SESSION['session_id'];

// 1. Cek apakah sepatu sudah ada di keranjang untuk user ini
$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_sepatu='$id_sepatu' AND session_id='$session_id'");

if (mysqli_num_rows($cek) > 0) {
    // 2a. Jika ada, UPDATE Qty
    mysqli_query($conn, "UPDATE keranjang SET qty = qty + 1 WHERE id_sepatu='$id_sepatu' AND session_id='$session_id'");
} else {
    // 2b. Jika belum, INSERT baru
    mysqli_query($conn, "INSERT INTO keranjang (id_sepatu, qty, session_id) VALUES ('$id_sepatu', 1, '$session_id')");
}

header("Location: keranjang.php");
exit();
?>