<?php
include 'koneksi.php'; // Pastikan file koneksi database sudah benar

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = trim($_POST['email']);
    $username = trim($_POST['user']);
    $password = $_POST['password'];

    // Validasi form kosong
    if (empty($email) || empty($username) || empty($password)) {
        header("Location: register.php?pesan=error");
        exit();
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?pesan=error");
        exit();
    }

    // Simpan data ke database tanpa enkripsi password
    $stmt = $konek->prepare("INSERT INTO User (Email, Username, Password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $password);

    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman login
        header("Location: index.php?pesan=success");
        exit();
    } else {
        // Jika gagal, redirect kembali ke halaman registrasi dengan pesan error
        header("Location: register.php?pesan=failed");
        exit();
    }
}
?>