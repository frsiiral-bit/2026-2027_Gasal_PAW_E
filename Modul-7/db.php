<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "penjualan";

// Koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Mengecek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
