<?php
session_start();
include 'koneksi.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

// Validasi input kosong
if (empty($username) || empty($password)) {
    header("Location: index.php?pesan=error");
    exit();
}

// Query untuk memeriksa username dan password
$query = "SELECT * FROM User WHERE Username = ? AND Password = ?";
$stmt = mysqli_prepare($konek, $query);
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($data = mysqli_fetch_assoc($result)) {
    // Jika username dan password cocok
    $_SESSION['username'] = $data['Username'];
    header("Location: home.php"); // Redirect ke halaman home
    exit();
} else {
    // Jika username atau password salah
    header("Location: index.php?pesan=invalid");
    exit();
}
?>