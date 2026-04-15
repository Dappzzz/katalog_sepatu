<?php
session_start();
include '../config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id_sepatu = $_GET['id'];
$user_id = $_SESSION['user_id'];
$cek = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_sepatu='$id_sepatu' AND id_user='$user_id'");

if (mysqli_num_rows($cek) > 0) {
    mysqli_query($conn, "UPDATE keranjang SET qty = qty + 1 WHERE id_sepatu='$id_sepatu' AND id_user='$user_id'");
} else {
    mysqli_query($conn, "INSERT INTO keranjang (id_sepatu, qty, id_user) VALUES ('$id_sepatu', 1, '$user_id')");
}
header("Location: ../keranjang.php");
exit();
