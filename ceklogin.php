<?php
// Memulai session
session_start();

// Menghubungkan ke koneksi database
include 'config.php';

// Menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Melakukan query untuk mencari username di tabel users
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
$cek   = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);
    
    // Memeriksa password
    if ($password == $data['password']) {
        
        // JIKA LOGIN BERHASIL -> Buat Session
        $_SESSION['username'] = $username;
        $_SESSION['status']   = "login";
        
        // JIKA FITUR COOKIE DICENTANG (REMEMBER ME)
        if (isset($_POST['remember'])) {
            setcookie('user_login', $username, time() + 86400, "/");
        }
        
        // Alihkan halaman ke dashboard.php
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Login gagal, password salah. Silakan coba lagi.";
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Login gagal, username tidak terdaftar. Silakan coba lagi.";
    header("Location: login.php");
    exit;
}
?>