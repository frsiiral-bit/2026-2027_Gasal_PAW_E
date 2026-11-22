<?php
include 'cek_login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
</head>
<body>

<h2>Halaman Laporan</h2>

<p>Username: <?php echo $_SESSION['username']; ?></p>

<p>Anda dapat mengakses halaman laporan.</p>

<a href="index.php">Kembali ke Home</a>

</body>
</html>