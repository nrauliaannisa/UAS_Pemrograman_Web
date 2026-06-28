<?php
// Memulai session
session_start();

// Jika user sudah login sebelumnya, langsung lempar ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <title>Login Aplikasi - SMK Negeri 2 Takalar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css"> <!-- Menggunakan CSS asli kamu -->
    </head>
    <body>
        <div class="container">
            <section class="login-box">
                <!-- Bagian Logo dan Nama Sekolah -->
                <div class="header-login">
                    <img src="images/logo-sekolah.jpg" alt="Logo SMK Negeri 2 Takalar" class="logo">
                    <h1>SMK NEGERI 2 TAKALAR</h1>
                </div>
                
                <!-- NOTIFIKASI ERROR (SESSION) -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem; border: 1px solid #f5c6cb; text-align: center;">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
                        ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="ceklogin.php">
                    <input type="text" placeholder="Username" id="username" name="username" required>
                    <input type="password" placeholder="Password" id="password" name="password" required>
                    
                    <!-- FITUR COOKIE (REMEMBER ME) -->
                    <div style="text-align: left; margin-bottom: 15px; font-size: 0.85rem; color: #555; display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat Saya (Cookie)</label>
                    </div>

                    <input type="submit" value="Login">
                </form>
            </section>
        </div>
    </body>
</html>