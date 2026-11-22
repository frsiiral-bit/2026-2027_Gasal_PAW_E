<?php
session_start();

// Jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>