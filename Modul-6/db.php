
<?php
// Menghubungkan PHP dengan database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "penjualan";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>