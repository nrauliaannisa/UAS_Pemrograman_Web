<?php
session_start();
include 'config.php';


$id             = $_POST['id'];
$nama           = $_POST['nama'];
$jk             = $_POST['jk'];
$tanggal_lahir  = $_POST['tanggal'];
$jurusan        = $_POST['jurusan'];
$foto_lama      = $_POST['foto_lama'];


$nama_foto = $_FILES['foto']['name'];
$tmp_foto  = $_FILES['foto']['tmp_name'];

if (!empty($nama_foto)) {
  
    $ekstensi    = pathinfo($nama_foto, PATHINFO_EXTENSION);
    $foto_baru   = "upload/" . time() . "_" . uniqid() . "." . $ekstensi;
    $target_path = "images/" . $foto_baru;

  
    if (move_uploaded_file($tmp_foto, $target_path)) {
        // Jika sedang edit data dan foto lamanya ada (bukan default), hapus foto lama biar storage tidak penuh
        if (!empty($id) && !empty($foto_lama) && $foto_lama != 'default.jpg' && file_exists("images/" . $foto_lama)) {
            unlink("images/" . $foto_lama);
        }
    } else {
        $foto_baru = (!empty($id)) ? $foto_lama : "default.jpg";
    }
} else {
    // Jika tidak mengunggah foto baru, pakai foto lama (jika proses edit) atau foto default (jika siswa baru)
    $foto_baru = (!empty($id)) ? $foto_lama : "default.jpg";
}

if (empty($id)) {
    // PROSES TAMBAH DATA BARU (CREATE)
    $query = "INSERT INTO siswa (nama, jk, tanggal_lahir, jurusan, foto) VALUES ('$nama', '$jk', '$tanggal_lahir', '$jurusan', '$foto_baru')";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data siswa berhasil ditambahkan dengan foto!";
    } else {
      
        die("Gagal menambahkan data ke database! Error: " . mysqli_error($koneksi));
    }
} else {
    // PROSES UPDATE DATA LAMA (UPDATE)
    $query = "UPDATE siswa SET nama='$nama', jk='$jk', tanggal_lahir='$tanggal_lahir', jurusan='$jurusan', foto='$foto_baru' WHERE id='$id'";
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['pesan'] = "Data siswa berhasil diperbarui!";
    } else {
      
        die("Gagal memperbarui data ke database! Error: " . mysqli_error($koneksi));
    }
}

// Alihkan kembali ke halaman tabel data siswa
header("Location: tabel-siswa.php");
exit;
?>