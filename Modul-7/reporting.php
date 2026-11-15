
<?php
include 'db.php';

// Mengambil tanggal dari form
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

// Query laporan penjualan harian
$sql = "SELECT waktu_transaksi, SUM(total) AS total_pendapatan
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

// Menyiapkan data grafik dan tabel
$tanggal = [];
$pendapatan = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    $tanggal[] = $row['waktu_transaksi'];
    $pendapatan[] = $row['total_pendapatan'];
}

// Query ringkasan
$sql_ringkasan = "SELECT
    COUNT(DISTINCT pelanggan_id) AS jumlah_pelanggan,
    COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi";

if ($tanggal_mulai != '' && $tanggal_selesai != '') {
    $sql_ringkasan .= " WHERE waktu_transaksi BETWEEN ? AND ?";
}

$stmt2 = mysqli_prepare($conn, $sql_ringkasan);

if ($tanggal_mulai != '' && $tanggal_selesai != '') {
    mysqli_stmt_bind_param($stmt2, "ss", $tanggal_mulai, $tanggal_selesai);
}

mysqli_stmt_execute($stmt2);
$ringkasan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reporting Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f4f6f9;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .chart-container {
            height: 350px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white;
            }

            .container {
                width: 100%;
                margin: 0;
            }

            .card {
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2 class="mb-4">Laporan Penjualan</h2>

    <!-- FORM FILTER -->
    <div class="card shadow-sm p-3 mb-4 no-print">

        <form method="GET" action="">

            <div class="row">

                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="form-control"
                        value="<?= htmlspecialchars($tanggal_mulai) ?>"
                        required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="form-control"
                        value="<?= htmlspecialchars($tanggal_selesai) ?>"
                        required>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>

                    <a href="reporting.php" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>

    <!-- TOMBOL CETAK DAN EXCEL -->
    <div class="mb-3 no-print">

        <button onclick="window.print()" class="btn btn-success">
            Cetak / Print
        </button>

        <a href="export_excel.php?tanggal_mulai=<?= urlencode($tanggal_mulai) ?>&tanggal_selesai=<?= urlencode($tanggal_selesai) ?>"
           class="btn btn-primary">
            Export Excel
        </a>

    </div>

    <!-- GRAFIK -->
    <div class="card shadow-sm p-4 mb-4">

        <h5 class="mb-3">Grafik Pendapatan Penjualan Harian</h5>

        <div class="chart-container">
            <canvas id="grafikPenjualan"></canvas>
        </div>

    </div>

    <!-- TABEL REKAPITULASI -->
    <div class="card shadow-sm p-4 mb-4">

        <h5 class="mb-3">Rekapitulasi Penjualan Harian</h5>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Total Pendapatan</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($data) > 0): ?>

                        <?php $no = 1; ?>

                        <?php foreach ($data as $row): ?>

                            <tr>
                                <td><?= $no++ ?></td>

                                <td>
                                    Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['waktu_transaksi']) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="3" class="text-center">
                                Tidak ada data penjualan.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- RINGKASAN -->
    <div class="row mb-4">

        <div class="col-md-6 mb-3">

            <div class="card shadow-sm p-4">

                <h6>Jumlah Pelanggan</h6>

                <h3 class="text-primary">
                    <?= number_format($ringkasan['jumlah_pelanggan'], 0, ',', '.') ?>
                </h3>

            </div>

        </div>

        <div class="col-md-6 mb-3">

            <div class="card shadow-sm p-4">

                <h6>jumlah pendapatan</h6>

                <h3 class="text-success">
                    Rp <?= number_format($ringkasan['total_pendapatan'], 0, ',', '.') ?>
                </h3>

            </div>

        </div>

    </div>

</div>

<!-- JAVASCRIPT CHART.JS -->
<script>

const tanggal = <?= json_encode($tanggal) ?>;
const pendapatan = <?= json_encode($pendapatan) ?>;

const ctx = document.getElementById('grafikPenjualan');

new Chart(ctx, {

    type: 'bar',

    data: {
        labels: tanggal,

        datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: pendapatan,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Pendapatan (Rp)'
                }
            },

            x: {
                title: {
                    display: true,
                    text: 'Tanggal Transaksi'
                }
            }
        }
    }

});

</script>

</body>
</html>
