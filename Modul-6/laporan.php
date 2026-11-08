
<?php
include 'db.php';

$sql = "SELECT
            transaksi.id AS id_transaksi,
            transaksi.waktu_transaksi,
            pelanggan.nama AS nama_pelanggan,
            barang.nama_barang,
            transaksi_detail.qty,
            transaksi_detail.harga,
            (transaksi_detail.qty * transaksi_detail.harga) AS subtotal,
            pembayaran.metode
        FROM transaksi
        JOIN pelanggan
            ON transaksi.pelanggan_id = pelanggan.id
        JOIN transaksi_detail
            ON transaksi.id = transaksi_detail.transaksi_id
        JOIN barang
            ON transaksi_detail.barang_id = barang.id
        LEFT JOIN pembayaran
            ON transaksi.id = pembayaran.transaksi_id
        ORDER BY transaksi.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
</head>
<body>

<h2>Laporan Penjualan</h2>

<a href="index.php">Kembali ke Dashboard</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID Transaksi</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
        <th>Metode Pembayaran</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id_transaksi']; ?></td>
        <td><?= $row['waktu_transaksi']; ?></td>
        <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
        <td><?= htmlspecialchars($row['nama_barang']); ?></td>
        <td><?= $row['qty']; ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td>Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
        <td><?= $row['metode'] ?? 'Belum dibayar'; ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>