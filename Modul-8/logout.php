<?php
session_start();

// Menghapus seluruh session
session_unset();

// Menghancurkan session
session_destroy();

// Mengarahkan kembali ke halaman login
header("Location: login.php");
exit;
?>