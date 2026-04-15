<?php
session_start();
include 'config.php';

$id_keranjang = $_GET['id'];

mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = $id_keranjang");

header("Location: keranjang.php");
exit();
?>