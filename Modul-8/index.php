<?php
include 'cek_login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Sistem Penjualan</title>
</head>
<body>

<h2>Sistem Penjualan</h2>

<p>Selamat datang, <?php echo $_SESSION['username']; ?></p>

<nav>
    <a href="index.php">Home</a> |

    <?php if ($_SESSION['level'] == 1) { ?>

        <a href="barang.php">Data Barang</a> |
        <a href="supplier.php">Data Supplier</a> |
        <a href="pelanggan.php">Data Pelanggan</a> |
        <a href="user.php">Data User</a> |

    <?php } ?>

    <a href="transaksi.php">Transaksi</a> |
    <a href="laporan.php">Laporan</a> |

    <a href="logout.php">Logout</a>
</nav>

<hr>

<h3>Halaman Home</h3>

<p>Anda berhasil login ke sistem penjualan.</p>

</body>
</html>