
<?php
include 'db.php';

$id = $_GET['id'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT * FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    die("Pelanggan tidak ditemukan!");
}

// Memeriksa transaksi pelanggan
$stmt = mysqli_prepare($conn, "
    SELECT COUNT(*) AS jumlah
    FROM transaksi
    WHERE pelanggan_id = ?
");

mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

$cek = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (isset($_POST['hapus'])) {

    if ($cek['jumlah'] > 0) {
        die("Pelanggan tidak bisa dihapus karena sudah memiliki transaksi!");
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php?pesan=Pelanggan berhasil dihapus");
        exit;
    } else {
        $error = "Gagal menghapus pelanggan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hapus Pelanggan</title>
</head>
<body>

<h2>Konfirmasi Hapus Pelanggan</h2>

<p>Nama: <?= htmlspecialchars($data['nama']); ?></p>
<p>ID: <?= htmlspecialchars($data['id']); ?></p>

<?php if ($cek['jumlah'] > 0) { ?>

    <p style="color:red;">
        Pelanggan sudah memiliki transaksi dan tidak dapat dihapus!
    </p>

    <a href="pelanggan.php">Kembali</a>

<?php } else { ?>

    <p>Apakah Anda yakin ingin menghapus pelanggan ini?</p>

    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <form method="POST">
        <button type="submit" name="hapus">Ya, Hapus</button>
        <a href="pelanggan.php">Batal</a>
    </form>

<?php } ?>

</body>
</html>
