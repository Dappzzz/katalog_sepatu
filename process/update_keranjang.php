<?php
session_start();
include '../config.php';
if (isset($_POST['update_cart'])) {
    $id_keranjangs = $_POST['id_keranjang'];
    $qtys = $_POST['qty'];
    for ($i = 0; $i < count($id_keranjangs); $i++) {
        if ($qtys[$i] > 0) {
            mysqli_query($conn, "UPDATE keranjang SET qty = {$qtys[$i]} WHERE id_keranjang = {$id_keranjangs[$i]}");
        }
    }
}
header("Location: ../keranjang.php");
exit();
