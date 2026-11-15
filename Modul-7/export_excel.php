
<?php

include 'db.php';

// Mengambil tanggal filter
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

// Query data transaksi harian
$sql = "SELECT
            waktu_transaksi,
            SUM(total) AS total_pendapatan
        FROM transaksi";

if ($tanggal_mulai != '' && $tanggal_selesai != '') {
    $sql .= " WHERE waktu_transaksi BETWEEN ? AND ?";
}

$sql .= " GROUP BY waktu_transaksi ORDER BY waktu_transaksi ASC";

$stmt = mysqli_prepare($conn, $sql);

if ($tanggal_mulai != '' && $tanggal_selesai != '') {
    mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Header untuk download Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

    <tr>
        <th colspan="3">LAPORAN PENJUALAN HARIAN</th>
    </tr>

    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)):
    ?>

    <tr>
        <td><?= $no++ ?></td>

        <td>
            <?= $row['total_pendapatan'] ?>
        </td>

        <td>
            <?= $row['waktu_transaksi'] ?>
        </td>
    </tr>

    <?php endwhile; ?>

</table>
