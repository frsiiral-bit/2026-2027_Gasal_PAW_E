
<?php
include 'db.php';

$query = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
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

    <h2>Data Pelanggan</h2>

    <a href="tambah_pelanggan.php" class="tambah">
        + Tambah Pelanggan
    </a>

    <?php if (isset($_GET['pesan'])) { ?>
        <p><?= htmlspecialchars($_GET['pesan']); ?></p>
    <?php } ?>

    <table>
        <tr>
            <th>No</th>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['id']); ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
            <td><?= htmlspecialchars($data['telp']); ?></td>
            <td><?= htmlspecialchars($data['alamat']); ?></td>

            <td>
                <a href="edit_pelanggan.php?id=<?= urlencode($data['id']); ?>">
                    Edit
                </a>

                |

                <a href="hapus_pelanggan.php?id=<?= urlencode($data['id']); ?>">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
