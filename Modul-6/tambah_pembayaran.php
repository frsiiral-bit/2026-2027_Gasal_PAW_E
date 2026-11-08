
<?php
include 'db.php';

// Mengambil transaksi yang belum dibayar
$query = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    LEFT JOIN pembayaran
        ON transaksi.id = pembayaran.transaksi_id
    WHERE pembayaran.id IS NULL
    ORDER BY transaksi.id DESC
");

if (isset($_POST['simpan'])) {

    $transaksi_id = (int) $_POST['transaksi_id'];
    $metode = $_POST['metode'];

    // Memeriksa metode pembayaran
    if (!in_array($metode, ['TUNAI', 'TRANSFER', 'EDC'], true)) {
        $error = "Metode pembayaran tidak valid!";
    } else {

        // Mengambil total transaksi
        $stmt = mysqli_prepare($conn, "
            SELECT total FROM transaksi WHERE id = ?
        ");

        mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
        mysqli_stmt_execute($stmt);

        $transaksi = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        );

        // Memeriksa detail barang
        $stmt = mysqli_prepare($conn, "
            SELECT COUNT(*) AS jumlah
            FROM transaksi_detail
            WHERE transaksi_id = ?
        ");

        mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
        mysqli_stmt_execute($stmt);

        $detail = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        );

        // Memeriksa apakah sudah dibayar
        $stmt = mysqli_prepare($conn, "
            SELECT id FROM pembayaran WHERE transaksi_id = ?
        ");

        mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
        mysqli_stmt_execute($stmt);

        $sudah_bayar = mysqli_stmt_get_result($stmt);

        if (!$transaksi) {

            $error = "Transaksi tidak ditemukan!";

        } elseif ($detail['jumlah'] == 0 || $transaksi['total'] <= 0) {

            $error = "Transaksi belum memiliki barang!";

        } elseif (mysqli_num_rows($sudah_bayar) > 0) {

            $error = "Transaksi ini sudah dibayar!";

        } else {

            $total = $transaksi['total'];

            // Menyimpan pembayaran
            $stmt = mysqli_prepare($conn, "
                INSERT INTO pembayaran
                (waktu_bayar, total, metode, transaksi_id)
                VALUES (NOW(), ?, ?, ?)
            ");

            mysqli_stmt_bind_param(
                $stmt, "isi",
                $total, $metode, $transaksi_id
            );

            if (mysqli_stmt_execute($stmt)) {

                header("Location: pembayaran.php");
                exit;

            } else {
                $error = "Gagal menyimpan pembayaran!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
</head>

<body>

<h2>Tambah Pembayaran</h2>

<?php if (isset($error)) { ?>
    <p style="color:red;">
        <?= htmlspecialchars($error); ?>
    </p>
<?php } ?>

<form method="POST">

    <p>Pilih Transaksi</p>

    <select name="transaksi_id" required>
        <option value="">-- Pilih Transaksi --</option>

        <?php while ($t = mysqli_fetch_assoc($query)) { ?>

            <option value="<?= $t['id']; ?>">
                Transaksi #<?= $t['id']; ?>
                - <?= htmlspecialchars($t['nama_pelanggan']); ?>
                - Rp <?= number_format($t['total'], 0, ',', '.'); ?>
            </option>

        <?php } ?>

    </select>

    <p>Metode Pembayaran</p>

    <select name="metode" required>
        <option value="">-- Pilih Metode --</option>
        <option value="TUNAI">Tunai</option>
        <option value="TRANSFER">Transfer</option>
        <option value="EDC">EDC</option>
    </select>

    <br><br>

    <button type="submit" name="simpan">
        Simpan Pembayaran
    </button>

    <a href="pembayaran.php">Kembali</a>

</form>

</body>
</html>
