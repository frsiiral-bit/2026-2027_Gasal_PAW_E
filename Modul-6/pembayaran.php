
<?php
include 'db.php';

// Mengambil data pembayaran
$query = mysqli_query($conn, "
    SELECT pembayaran.*,
           transaksi.waktu_transaksi,
           pelanggan.nama AS nama_pelanggan
    FROM pembayaran
    JOIN transaksi ON pembayaran.transaksi_id = transaksi.id
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY pembayaran.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pembayaran</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            margin: 0;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #263b55;
            color: white;
        }

        .tambah {
            display: inline-block;
            background: #27ae60;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 15px;
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
</nav>

<div class="container">

    <h2>Data Pembayaran</h2>

    <a href="tambah_pembayaran.php" class="tambah">
        + Tambah Pembayaran
    </a>

    <table>

        <tr>
            <th>No</th>
            <th>ID Pembayaran</th>
            <th>Tanggal Bayar</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Metode</th>
            <th>ID Transaksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id']; ?></td>
            <td><?= $data['waktu_bayar']; ?></td>
            <td><?= htmlspecialchars($data['nama_pelanggan']); ?></td>

            <td>
                Rp <?= number_format($data['total'], 0, ',', '.'); ?>
            </td>

            <td><?= $data['metode']; ?></td>
            <td><?= $data['transaksi_id']; ?></td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
