
<?php
include 'db.php';

// Mengambil data barang dan supplier
$query = mysqli_query($conn, "
    SELECT barang.*, supplier.nama AS nama_supplier
    FROM barang
    LEFT JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
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

        .edit {
            color: blue;
        }

        .hapus {
            color: red;
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

    <h2>Data Barang</h2>

    <a href="tambah_barang.php" class="tambah">
        + Tambah Barang
    </a>

    <?php if (isset($_GET['pesan'])) { ?>
        <p><?= htmlspecialchars($_GET['pesan']); ?></p>
    <?php } ?>

    <table>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Supplier</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['kode_barang']); ?></td>
            <td><?= htmlspecialchars($data['nama_barang']); ?></td>
            <td>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
            <td><?= $data['stok']; ?></td>
            <td><?= htmlspecialchars($data['nama_supplier'] ?? '-'); ?></td>

            <td>
                <a class="edit"
                   href="edit_barang.php?id=<?= $data['id']; ?>">
                   Edit
                </a>

                |

                <a class="hapus"
                   href="hapus_barang.php?id=<?= $data['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus barang ini?')">
                   Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
