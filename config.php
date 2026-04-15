<?php
$host = "localhost";
$user = "risyadmaulanadaffa";
$pass = "12345";
$db   = "db_apksepatu"; // Sesuaikan jika nama database berbeda

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
