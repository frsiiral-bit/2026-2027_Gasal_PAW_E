
<?php
include 'db.php';

$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");

if (isset($_POST['simpan'])) {

    $tanggal = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $pelanggan_id = $_POST['pelanggan_id'];

    $stmt = mysqli_prepare($conn, "
        INSERT INTO transaksi
        (waktu_transaksi, keterangan, total, pelanggan_id)
        VALUES (?, ?, 0, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt, "sss",
        $tanggal, $keterangan, $pelanggan_id
    );

    if (mysqli_stmt_execute($stmt)) {

        $id = mysqli_insert_id($conn);

        header("Location: detail_transaksi.php?id=" . $id);
        exit;

    } else {
        $error = "Gagal membuat transaksi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
</head>
<body>

<h2>Tambah Transaksi Baru</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">

    <p>Tanggal Transaksi</p>
    <input type="date" name="waktu_transaksi"
           value="<?= date('Y-m-d'); ?>" required>

    <p>Pelanggan</p>

    <select name="pelanggan_id" required>
        <option value="">-- Pilih Pelanggan --</option>

        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

            <option value="<?= htmlspecialchars($p['id']); ?>">
                <?= htmlspecialchars($p['nama']); ?>
            </option>

        <?php } ?>

    </select>

    <p>Keterangan</p>
    <textarea name="keterangan"></textarea>

    <br><br>

    <button type="submit" name="simpan">
        Simpan Transaksi
    </button>

    <a href="transaksi.php">Kembali</a>

</form>

</body>
</html>
