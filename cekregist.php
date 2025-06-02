<?php
include 'koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

if (mysqli_query($konek, $sql)) {
    header("Location: index.php?pesan=success");
} else {
    header("Location: regist.php?pesan=gagal");
    exit;
}
?>
