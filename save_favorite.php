<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$song_id = $_POST['song_id'] ?? null;

if ($song_id) {
    // Cek apakah sudah difavoritkan
    $check = $konek->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND song_id = ?");
    $check->bind_param("ii", $user_id, $song_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        // Hapus dari favorit (toggle off)
        $delete = $konek->prepare("DELETE FROM favorites WHERE user_id = ? AND song_id = ?");
        $delete->bind_param("ii", $user_id, $song_id);
        $delete->execute();
        echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Removed from favorites']);
    } else {
        // Tambah ke favorit (toggle on)
        $insert = $konek->prepare("INSERT INTO favorites (user_id, song_id) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $song_id);
        $insert->execute();
        echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Added to favorites']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No song ID provided']);
}
?>