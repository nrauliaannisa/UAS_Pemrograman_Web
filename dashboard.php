<?php
// Memulai session & menghubungkan dengan database
session_start();
include 'config.php';

// Mencegah akses tanpa login (Fitur Session Keamanan)
if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

// ALUR TAMBAHAN: Menghitung jumlah total siswa aktif dari database secara real-time
$hitung_siswa = mysqli_query($koneksi, "SELECT * FROM siswa");
$total_siswa  = mysqli_num_rows($hitung_siswa);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard - SMKN 2 Takalar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="images/logo-sekolah.jpg" alt="Logo SMKN 2 Takalar" class="logo-header">
            <span class="header-title">DASHBOARD SMKN 2 TAKALAR</span>
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar-navy">
            <ul class="menu-list">
                <li><a href="dashboard.php" class="aktif">Dashboard</a></li>
                <li><a href="tabel-siswa.php">Data Siswa</a></li>
                <li><a href="form-siswa.php">Form Siswa</a></li>
                <li><a href="landing-page.html">Beranda</a></li>
                <li><a href="logout.php" class="logout-link">Keluar</a></li>        
            </ul>
        </aside>

        <section class="main-content">
            <div class="welcome-banner">
                <div class="banner-info">
                    <h2 class="banner-title">Selamat Datang di Panel Admin, <?php echo $_SESSION['username']; ?>!</h2>
                    <p class="banner-subtitle">Sistem Informasi Manajemen Data Siswa SMK Negeri 2 Takalar.</p>
                </div>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon icon-siswa">S</div>
                    <div class="stat-data">
                        <p class="stat-label">Total Siswa Aktif</p>
                        <h3 class="stat-number"><?php echo $total_siswa; ?> Siswa</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon icon-jurusan">J</div>
                    <div class="stat-data">
                        <p class="stat-label">Program Keahlian</p>
                        <h3 class="stat-number">5 Jurusan</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon icon-kalender">K</div>
                    <div class="stat-data">
                        <p class="stat-label">Kalender Academic</p>
                        <h3 class="stat-number" id="tanggalHari"></h3>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer-bottom">
        <p>&copy; 2026 SMK Negeri 2 Takalar. All Rights Reserved.</p>
    </footer>

    <script>
        const today = new Date();
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById('tanggalHari').textContent = today.toLocaleDateString('id-ID', options);
    </script>
</body>
</html>