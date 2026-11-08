
<?php
include 'db.php';

// Mengambil data supplier
$supplier = mysqli_query($conn, "SELECT * FROM supplier");

if (isset($_POST['simpan'])) {

    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $stmt = mysqli_prepare($conn, "
        INSERT INTO barang
        (kode_barang, nama_barang, harga, stok, supplier_id)
        VALUES (?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt, "ssiii",
        $kode, $nama, $harga, $stok, $supplier_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: barang.php?pesan=Data berhasil ditambahkan");
        exit;
    } else {
        $error = "Gagal menambahkan data: " . mysqli_stmt_error($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>

<h2>Tambah Data Barang</h2>

<?php if (isset($error)) echo "<p>$error</p>"; ?>

<form method="POST">

    <p>Kode Barang</p>
    <input type="text" name="kode_barang" required>

    <p>Nama Barang</p>
    <input type="text" name="nama_barang" required>

    <p>Harga</p>
    <input type="number" name="harga" min="0" required>

    <p>Stok</p>
    <input type="number" name="stok" min="0" required>

    <p>Supplier</p>
    <select name="supplier_id" required>
        <option value="">-- Pilih Supplier --</option>

        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id']; ?>">
                <?= htmlspecialchars($s['nama']); ?>
            </option>
        <?php } ?>

    </select>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="barang.php">Kembali</a>

</form>

</body>
</html>
