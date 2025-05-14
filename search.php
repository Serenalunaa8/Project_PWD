<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
<?php
include 'koneksi.php'; 

// Query untuk mengambil 5 lagu terbaru
$sql = "SELECT s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url 
        FROM songs s
        JOIN artists a ON s.artist_id = a.id
        ORDER BY s.id DESC LIMIT 5";

$result = $koneksi->query($sql); // Menjalankan query

if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="d-flex align-items-center mb-3">
            <img src="<?= htmlspecialchars($row['cover_image_url']) ?>" 
                 alt="<?= htmlspecialchars($row['song_title']) ?>" 
                 class="me-3 rounded-3" width="48" height="48">
            <div>
                <p class="mb-0"><?= htmlspecialchars($row['song_title']) ?></p>
                <small class="text-white-50"><?= htmlspecialchars($row['artist_name']) ?></small>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="text-white-50">No trending songs found.</p>
<?php endif; ?>

<?php $koneksi->close(); ?>
  
</body>
</html>