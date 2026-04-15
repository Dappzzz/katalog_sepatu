<?php
session_start();
include '../config.php';
mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = " . $_GET['id']);
header("Location: ../keranjang.php");
exit();
