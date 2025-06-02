<?php
session_start();
include "koneksi.php";

$username = mysqli_real_escape_string($konek, $_POST['username']);
$password = mysqli_real_escape_string($konek, $_POST['password']);

$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$query = mysqli_query($konek, $sql) or die("Query error: " . mysqli_error($konek));

if ($query && mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];

    header("Location: home.php");
    exit;
} else {
    header("Location: index.php?pesan=gagal");
    exit;
}
?>