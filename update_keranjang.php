<?php
session_start();
include 'config.php';

if (isset($_POST['update_cart'])) {
    $id_keranjangs = $_POST['id_keranjang']; // Ini berupa array
    $qtys = $_POST['qty'];                   // Ini berupa array

    // Lakukan update untuk setiap baris
    for ($i = 0; $i < count($id_keranjangs); $i++) {
        $id = $id_keranjangs[$i];
        $qty = $qtys[$i];

        // Pastikan qty tidak kurang dari 1
        if ($qty > 0) {
            mysqli_query($conn, "UPDATE keranjang SET qty = $qty WHERE id_keranjang = $id");
        }
    }
}

header("Location: keranjang.php");
exit();
