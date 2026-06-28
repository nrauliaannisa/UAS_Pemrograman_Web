<?php
// Memulai session & menghubungkan database
session_start();
include 'config.php';

// Proteksi halaman dengan Session
if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

// Ambil data dari tabel siswa
$query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Siswa - SMKN 2 Takalar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/tabel.css">
</head>

<body>
    <header>
        <div class="header-content">
            <img src="images/logo-sekolah.jpg" alt="Logo" class="logo-header">
            <span class="header-title">DATA SISWA SMKN 2 TAKALAR</span>
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar-manual">
            <ul class="menu-list">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="tabel-siswa.php" class="aktif">Data Siswa</a></li>
                <li><a href="form-siswa.php">Form Siswa</a></li>
                <li><a href="landing-page.html">Beranda</a></li>
                <li><a href="logout.php" class="logout-link">Keluar</a></li>
            </ul>
        </aside>

        <section class="main-content">
            <div class="content-header">
                <h2 class="judul-halaman">Data Siswa SMKN 2 Takalar</h2>
                <a href="form-siswa.php" class="btn-tambah">+ Tambah Siswa</a>
            </div>

            <?php if (isset($_SESSION['pesan'])): ?>
                <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem; border: 1px solid #c3e6cb;">
                    <?php 
                        echo $_SESSION['pesan']; 
                        unset($_SESSION['pesan']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Lengkap</th>
                            <th>L/P</th>
                            <th>Tanggal Lahir</th>
                            <th>Jurusan / Program Keahlian</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        // Melakukan perulangan untuk menampilkan data dari database
                        while($data = mysqli_fetch_assoc($query)) { 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <img src="images/<?php echo $data['foto']; ?>" alt="Foto Siswa" class="img-siswa" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50px;">
                            </td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['jk']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($data['tanggal_lahir'])); ?></td>
                            <td><?php echo $data['jurusan']; ?></td>
                            <td class="text-center">
                                <a href="form-siswa.php?id=<?php echo $data['id']; ?>" class="btn-aksi edit">Edit</a>
                                <a href="hapus-siswa.php?id=<?php echo $data['id']; ?>" class="btn-aksi hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>   
                        </tr>
                        <?php } ?>
                        
                        <?php if (mysqli_num_rows($query) == 0): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #888; padding: 20px;">Belum ada data siswa. Silakan tambah data terlebih dahulu.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2026 SMK Negeri 2 Takalar. All Rights Reserved.</p>
    </footer>
</body>
</html>