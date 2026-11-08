
<?php
include 'db.php';

$id = (int) ($_GET['id'] ?? 0);

// Mengambil data transaksi
$stmt = mysqli_prepare($conn, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    WHERE transaksi.id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$transaksi) {
    die("Transaksi tidak ditemukan!");
}

// Fungsi menghitung ulang total transaksi
function updateTotal($conn, $id) {

    $stmt = mysqli_prepare($conn, "
        SELECT COALESCE(SUM(harga * qty), 0) AS total
        FROM transaksi_detail
        WHERE transaksi_id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $hasil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $total = $hasil['total'];

    $stmt = mysqli_prepare($conn, "
        UPDATE transaksi SET total = ? WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "ii", $total, $id);
    mysqli_stmt_execute($stmt);
}

// Menambahkan barang ke transaksi
if (isset($_POST['tambah'])) {

    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($barang_id <= 0 || $qty <= 0) {
        $error = "Pilih barang dan masukkan jumlah yang benar!";
    } else {

        // Memeriksa barang sudah digunakan atau belum
        $stmt = mysqli_prepare($conn, "
            SELECT COUNT(*) AS jumlah
            FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?
        ");

        mysqli_stmt_bind_param($stmt, "ii", $id, $barang_id);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($cek['jumlah'] > 0) {

            $error = "Barang sudah dimasukkan ke transaksi!";

        } else {

            // Mengambil harga barang
            $stmt = mysqli_prepare($conn, "
                SELECT harga FROM barang WHERE id = ?
            ");

            mysqli_stmt_bind_param($stmt, "i", $barang_id);
            mysqli_stmt_execute($stmt);

            $barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

            if (!$barang) {

                $error = "Barang tidak ditemukan!";

            } else {

                $harga = $barang['harga'];

                // Menyimpan detail transaksi
                $stmt = mysqli_prepare($conn, "
                    INSERT INTO transaksi_detail
                    (transaksi_id, barang_id, harga, qty)
                    VALUES (?, ?, ?, ?)
                ");

                mysqli_stmt_bind_param(
                    $stmt, "iiii",
                    $id, $barang_id, $harga, $qty
                );

                if (mysqli_stmt_execute($stmt)) {

                    updateTotal($conn, $id);

                    header("Location: detail_transaksi.php?id=" . $id);
                    exit;

                } else {
                    $error = "Gagal menambahkan barang!";
                }
            }
        }
    }
}

// Menghapus barang dari detail transaksi
if (isset($_POST['hapus'])) {

    $barang_id = (int) $_POST['barang_id'];

    // Memeriksa apakah detail barang ada
    $stmt = mysqli_prepare($conn, "
        SELECT COUNT(*) AS jumlah
        FROM transaksi_detail
        WHERE transaksi_id = ? AND barang_id = ?
    ");

    mysqli_stmt_bind_param($stmt, "ii", $id, $barang_id);
    mysqli_stmt_execute($stmt);

    $cek = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($cek['jumlah'] > 0) {

        $stmt = mysqli_prepare($conn, "
            DELETE FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?
        ");

        mysqli_stmt_bind_param($stmt, "ii", $id, $barang_id);
        mysqli_stmt_execute($stmt);

        updateTotal($conn, $id);
    }

    header("Location: detail_transaksi.php?id=" . $id);
    exit;
}

// Mengambil seluruh barang dan status pemilihannya
$stmt = mysqli_prepare($conn, "
    SELECT barang.*,
    transaksi_detail.barang_id AS sudah_dipilih
    FROM barang
    LEFT JOIN transaksi_detail
    ON barang.id = transaksi_detail.barang_id
    AND transaksi_detail.transaksi_id = ?
    ORDER BY barang.nama_barang ASC
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$daftar_barang = mysqli_stmt_get_result($stmt);

// Mengambil detail barang transaksi
$stmt = mysqli_prepare($conn, "
    SELECT transaksi_detail.*, barang.nama_barang,
    barang.kode_barang
    FROM transaksi_detail
    JOIN barang ON transaksi_detail.barang_id = barang.id
    WHERE transaksi_detail.transaksi_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$detail = mysqli_stmt_get_result($stmt);

// Mengambil total transaksi terbaru
$stmt = mysqli_prepare($conn, "
    SELECT total FROM transaksi WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$total = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            margin: 0;
        }

        .container {
            padding: 25px;
        }

        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
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

        button {
            padding: 8px 15px;
            cursor: pointer;
        }

        .total {
            color: green;
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Detail Transaksi</h2>

    <div class="box">

        <p>ID Transaksi: <?= $transaksi['id']; ?></p>

        <p>Tanggal: <?= $transaksi['waktu_transaksi']; ?></p>

        <p>Pelanggan:
            <?= htmlspecialchars($transaksi['nama_pelanggan']); ?>
        </p>

        <p>Keterangan:
            <?= htmlspecialchars($transaksi['keterangan'] ?? ''); ?>
        </p>

    </div>

    <div class="box">

        <h3>Tambah Barang</h3>

        <?php if (isset($error)) { ?>
            <p style="color:red;">
                <?= htmlspecialchars($error); ?>
            </p>
        <?php } ?>

        <form method="POST">

            <p>Pilih Barang</p>

            <select name="barang_id" required>

                <option value="">-- Pilih Barang --</option>

                <?php while ($b = mysqli_fetch_assoc($daftar_barang)) { ?>

                    <option
                        value="<?= $b['id']; ?>"
                        <?= $b['sudah_dipilih'] !== null ? 'disabled' : ''; ?>>

                        <?= htmlspecialchars($b['nama_barang']); ?>
                        - Rp <?= number_format($b['harga'], 0, ',', '.'); ?>

                        <?= $b['sudah_dipilih'] !== null
                            ? ' (Sudah Dipilih)' : ''; ?>

                    </option>

                <?php } ?>

            </select>

            <p>Jumlah Barang</p>

            <input type="number" name="qty" min="1" required>

            <br><br>

            <button type="submit" name="tambah">
                Tambah Barang
            </button>

        </form>

    </div>

    <div class="box">

        <h3>Daftar Barang Transaksi</h3>

        <table>

            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;

            while ($d = mysqli_fetch_assoc($detail)) {
                $subtotal = $d['harga'] * $d['qty'];
            ?>

            <tr>
                <td><?= $no++; ?></td>

                <td><?= htmlspecialchars($d['kode_barang']); ?></td>

                <td><?= htmlspecialchars($d['nama_barang']); ?></td>

                <td>
                    Rp <?= number_format($d['harga'], 0, ',', '.'); ?>
                </td>

                <td><?= $d['qty']; ?></td>

                <td>
                    Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                </td>

                <td>

                    <form method="POST"
                        onsubmit="return confirm('Hapus barang ini dari transaksi?')">

                        <input type="hidden" name="barang_id"
                            value="<?= $d['barang_id']; ?>">

                        <button type="submit" name="hapus">
                            Hapus
                        </button>

                    </form>

                </td>
            </tr>

            <?php } ?>

        </table>

        <h3>Total Transaksi:</h3>

        <p class="total">
            Rp <?= number_format($total['total'], 0, ',', '.'); ?>
        </p>

    </div>

    <a href="transaksi.php">Kembali ke Transaksi</a>

    |

    <a href="pembayaran.php">Ke Pembayaran</a>

</div>

</body>
</html>
