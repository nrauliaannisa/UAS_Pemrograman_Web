<?php
session_start();
session_destroy(); // Menghapus semua session login

// Hapus cookie remember me jika ada
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, '/');
}

header("Location: login.php");
exit;
?>