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
    <title>Data User</title>
</head>
<body>

<h2>Data User</h2>

<p>Halaman Data User hanya dapat diakses oleh Owner.</p>

<a href="index.php">Kembali ke Home</a>

</body>
</html>