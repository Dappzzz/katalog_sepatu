<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

if (isset($_POST['register'])) {
    $nama = $_POST['nama_lengkap'];
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if(mysqli_num_rows($cek) > 0) {
        $error = "Username sudah dipakai!";
    } else {
        $query = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$user', '$pass', '$nama')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - ZXYAN Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm border-t-4 border-gray-900">
        
        <div class="flex justify-center items-center mb-6">
            <div class="bg-gray-900 text-white font-black text-3xl px-4 py-2 rounded-lg tracking-widest shadow-md" style="font-family: 'Montserrat', sans-serif;">
                ZXYAN
            </div>
        </div>
        <p class="text-gray-500 text-center text-sm mb-6 font-semibold uppercase tracking-wider">Join The Culture</p>

        <?php if(isset($error)) { echo "<div class='bg-red-100 text-red-600 p-3 rounded mb-4 text-sm'>$error</div>"; } ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required 
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:bg-white transition">
            <input type="text" name="username" placeholder="Username" required 
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:bg-white transition">
            <input type="password" name="password" placeholder="Password" required 
                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:bg-white transition">
            <button type="submit" name="register" 
                    class="w-full bg-gray-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-800 transition shadow-lg mt-2">
                DAFTAR SEKARANG
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun? <a href="login.php" class="text-gray-900 font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>

</body>
</html>