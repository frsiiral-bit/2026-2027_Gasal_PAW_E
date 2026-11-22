<?php
include 'cek_login.php';

if ($_SESSION['level'] != 1) {
    echo "Anda tidak memiliki hak akses!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>

<h2>Data Supplier</h2>

<p>Halaman Data Supplier hanya dapat diakses oleh Owner.</p>

<a href="index.php">Kembali ke Home</a>

</body>
</html>