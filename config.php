<?php
$host = "localhost";
$user = "risyadmaulanadaffa";
$pass = "12345";
$db   = "db_apksepatu"; 

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
