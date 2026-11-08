
<?php
include 'db.php';

$query = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
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

    <h2>Data Transaksi</h2>

    <a href="tambah_transaksi.php" class="tambah">
        + Tambah Transaksi
    </a>

    <table>
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id']; ?></td>
            <td><?= $data['waktu_transaksi']; ?></td>
            <td><?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?></td>
            <td><?= htmlspecialchars($data['keterangan'] ?? ''); ?></td>
            <td>Rp <?= number_format($data['total'], 0, ',', '.'); ?></td>

            <td>
                <a href="detail_transaksi.php?id=<?= $data['id']; ?>">
                    Detail
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
