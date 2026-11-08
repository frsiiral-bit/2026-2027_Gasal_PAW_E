
<?php
include 'db.php';

// Menghitung jumlah data
$supplier = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM supplier"));
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM barang"));
$pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM pelanggan"));
$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM transaksi"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Penjualan</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f2f2f2;
        }

        header {
            background: #263b55;
            color: white;
            padding: 20px;
        }

        nav {
            background: #34495e;
            padding: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            padding: 25px;
        }

        .card {
            display: inline-block;
            background: white;
            padding: 25px;
            margin: 10px;
            width: 180px;
            border-radius: 8px;
            box-shadow: 0 2px 5px #ccc;
        }

        .card h2 {
            color: #2980b9;
        }
    </style>
</head>

<body>

<header>
    <h2>Aplikasi Penjualan</h2>
</header>

<nav>
    <a href="index.php">Dashboard</a>
    <a href="barang.php">Barang</a>
    <a href="pelanggan.php">Pelanggan</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="pembayaran.php">Pembayaran</a>
    <a href="laporan.php">Laporan Penjualan</a>
</nav>

<div class="container">

    <h2>Dashboard</h2>
    <p>Selamat datang di aplikasi penjualan.</p>

    <div class="card">
        <h3>Supplier</h3>
        <h2><?= $supplier['jumlah']; ?></h2>
    </div>

    <div class="card">
        <h3>Barang</h3>
        <h2><?= $barang['jumlah']; ?></h2>
    </div>

    <div class="card">
        <h3>Pelanggan</h3>
        <h2><?= $pelanggan['jumlah']; ?></h2>
    </div>

    <div class="card">
        <h3>Transaksi</h3>
        <h2><?= $transaksi['jumlah']; ?></h2>
    </div>

</div>

</body>
</html>
