<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sekolah";

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Memeriksa apakah koneksi sukses atau gagal
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>