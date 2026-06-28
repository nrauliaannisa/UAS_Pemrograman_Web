<?php
session_start();
include 'config.php';

// Proteksi halaman dengan Session
if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

// Inisialisasi variabel kosong untuk form tambah data
$id = "";
$nama = "";
$jk = "";
$tanggal_lahir = "";
$jurusan = "";
$foto_lama = "";
$judul_form = "Tambah Data Siswa";

// FITUR UPDATE: Jika ada ID di URL, berarti user ingin mengedit data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $judul_form = "Edit Data Siswa";
    
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    
    if ($data) {
        $nama = $data['nama'];
        $jk = $data['jk'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $jurusan = $data['jurusan'];
        $foto_lama = $data['foto'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title><?php echo $judul_form; ?> - SMKN 2 Takalar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="images/logo-sekolah.jpg" alt="Logo SMKN 2 Takalar" class="logo-header">
            <span class="header-title">FORM SMKN 2 Takalar</span>
        </div>
    </header>

    <div class="main-container">
        <aside>
            <ul class="menu-sidebar">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="tabel-siswa.php">Data Siswa</a></li>
                <li><a href="form-siswa.php" class="aktif">Form Siswa</a></li> 
                <li><a href="landing-page.html">Beranda</a></li>
                <li><a href="logout.php" class="menu-logout">Keluar</a></li>        
            </ul>
        </aside>

        <section class="main-content">
            <div class="container-form">
                <h2 class="form-title"><?php echo $judul_form; ?></h2>
                <hr class="divider">
                
                <form action="simpan-siswa.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="foto_lama" value="<?php echo $foto_lama; ?>">

                    <div class="field-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="input-custom" placeholder="Masukkan Nama Lengkap" value="<?php echo $nama; ?>" required>
                    </div>

                    <div class="field-group">
                        <label>Jenis Kelamin</label>
                        <div class="radio-options">
                            <label><input type="radio" name="jk" value="L" <?php if($jk == 'L') echo 'checked'; ?> required> Laki-laki</label>
                            <label><input type="radio" name="jk" value="P" <?php if($jk == 'P') echo 'checked'; ?> required> Perempuan</label>
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="tanggal">Tanggal Lahir</label>
                        <input type="date" id="tanggal" name="tanggal" class="input-custom" value="<?php echo $tanggal_lahir; ?>" required>
                    </div>

                    <div class="field-group">
                        <label for="jurusan">Program Keahlian</label>
                        <select id="jurusan" name="jurusan" class="input-custom" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Komputer & Jaringan" <?php if($jurusan == 'Teknik Komputer & Jaringan') echo 'selected'; ?>>Teknik Komputer & Jaringan</option>
                            <option value="Rekayasa Perangkat Lunak" <?php if($jurusan == 'Rekayasa Perangkat Lunak') echo 'selected'; ?>>Rekayasa Perangkat Lunak</option>
                            <option value="Teknik Sepeda Motor" <?php if($jurusan == 'Teknik Sepeda Motor') echo 'selected'; ?>>Teknik Sepeda Motor</option>
                            <option value="Teknik Kendaraan Ringan" <?php if($jurusan == 'Teknik Kendaraan Ringan') echo 'selected'; ?>>Teknik Kendaraan Ringan</option>
                            <option value="Bisnis Retail" <?php if($jurusan == 'Bisnis Retail') echo 'selected'; ?>>Bisnis Retail</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="foto">Foto Profil Siswa</label>
                        <?php if (!empty($foto_lama)): ?>
                            <div style="margin-bottom: 10px;">
                                <small style="color: #666; display: block;">Foto saat ini:</small>
                                <img src="images/<?php echo $foto_lama; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                            </div>
                        <?php endif; ?>
                        <input type="file" id="foto" name="foto" accept="image/*" style="padding: 5px 0;">
                        <small style="color: #888; display: block; margin-top: 5px;">*Format gambar bebas (JPG/PNG). Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn-submit">Simpan Data</button>
                        <a href="tabel-siswa.php" class="btn-reset" style="text-decoration:none; display:inline-block; text-align:center; padding-top:10px;">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <footer class="footer-bottom">
        <p>&copy; 2026 SMK Negeri 2 Takalar. All Rights Reserved.</p>
    </footer>
</body>
</html>