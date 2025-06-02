<?php
session_start();
include 'koneksi.php';

// Validasi input
if (!isset($_SESSION['user_id']) || !isset($_POST['song_id'])) {
    die("Invalid request");
}

$user_id = (int)$_SESSION['user_id'];
$song_id = (int)$_POST['song_id'];

// Simpan ke play_history
$sql = "INSERT INTO play_history (user_id, song_id, played_at) VALUES ($user_id, $song_id, NOW())";
$query = mysqli_query($konek, $sql);

// Update play_count di tabel songs
$update_sql = "UPDATE songs SET play_count = play_count + 1 WHERE id = $song_id";
mysqli_query($konek, $update_sql);

// Debugging (bisa dihapus di production)
if (!$query) {
    error_log("Error saving play history: " . mysqli_error($konek));
}
?>