<?php
include 'cek_login.php';

// Proteksi khusus Owner
if ($_SESSION['level'] != 1) {
    echo "Anda tidak memiliki hak akses!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<h2>Data Barang</h2>

<p>Halaman Data Barang hanya dapat diakses oleh Owner.</p>

<a href="index.php">Kembali ke Home</a>

</body>
</html>