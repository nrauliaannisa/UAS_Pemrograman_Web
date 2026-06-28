<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil info nama foto siswa sebelum dihapus dari database
    $cari_foto = mysqli_query($koneksi, "SELECT foto FROM siswa WHERE id = '$id'");
    $data_foto = mysqli_fetch_assoc($cari_foto);
    $nama_foto = $data_foto['foto'];

    // Hapus file fisiknya dari folder images/ jika bukan foto default
    if (!empty($nama_foto) && $nama_foto != 'default.jpg' && file_exists("images/" . $nama_foto)) {
        unlink("images/" . $nama_foto);
    }

    // Hapus data dari database
    $query = "DELETE FROM siswa WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data siswa dan foto berhasil dihapus!";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus data siswa.";
    }
}

header("Location: tabel-siswa.php");
exit;
?>