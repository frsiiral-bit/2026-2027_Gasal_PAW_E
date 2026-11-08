
<?php
include 'db.php';

if (isset($_POST['simpan'])) {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn, "
        INSERT INTO pelanggan
        (id, nama, jenis_kelamin, telp, alamat)
        VALUES (?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt, "sssss",
        $id, $nama, $jk, $telp, $alamat
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php?pesan=Data berhasil ditambahkan");
        exit;
    } else {
        $error = "Gagal menambahkan pelanggan. Pastikan ID belum digunakan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
</head>
<body>

<h2>Tambah Data Pelanggan</h2>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">

    <p>ID Pelanggan</p>
    <input type="text" name="id" required>

    <p>Nama Pelanggan</p>
    <input type="text" name="nama" required>

    <p>Jenis Kelamin</p>
    <select name="jenis_kelamin" required>
        <option value="">-- Pilih --</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <p>Nomor Telepon</p>
    <input type="text" name="telp" required>

    <p>Alamat</p>
    <textarea name="alamat" required></textarea>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="pelanggan.php">Kembali</a>

</form>

</body>
</html>
