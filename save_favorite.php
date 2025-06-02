<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$song_id = $_POST['song_id'] ?? null;

if (!$song_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Song ID required']);
    exit;
}

// Cek apakah sudah difavoritkan
$check = $konek->prepare("SELECT * FROM favorites WHERE user_id = ? AND song_id = ?");
$check->bind_param("ii", $user_id, $song_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Hapus dari favorit
    $delete = $konek->prepare("DELETE FROM favorites WHERE user_id = ? AND song_id = ?");
    $delete->bind_param("ii", $user_id, $song_id);
    
    if ($delete->execute()) {
        echo json_encode([
            'success' => true,
            'action' => 'removed',
            'message' => 'Removed from favorites'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to remove from favorites'
        ]);
    }
} else {
    // Tambah ke favorit
    $insert = $konek->prepare("INSERT INTO favorites (user_id, song_id) VALUES (?, ?)");
    $insert->bind_param("ii", $user_id, $song_id);
    
    if ($insert->execute()) {
        echo json_encode([
            'success' => true,
            'action' => 'added',
            'message' => 'Added to favorites'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add to favorites'
        ]);
    }
}
?>