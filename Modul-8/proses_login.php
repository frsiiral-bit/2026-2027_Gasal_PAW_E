<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Mengambil data user dari database
$query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

$data = mysqli_fetch_assoc($query);

// Memeriksa username dan password
if ($data && $password == $data['password']) {

    // Membuat session
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];

    // Mengarahkan ke halaman utama
    header("Location: index.php");
    exit;

} else {

    echo "Username atau password salah!";
    echo "<br><a href='login.php'>Kembali ke Login</a>";

}
?>