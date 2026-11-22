<?php
include 'cek_login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
</head>
<body>

<h2>Halaman Transaksi</h2>

<p>Username: <?php echo $_SESSION['username']; ?></p>

<p>Anda dapat mengakses halaman transaksi.</p>

<a href="index.php">Kembali ke Home</a>

</body>
</html>