<?php
include 'koneksi.php'; // Pastikan koneksi database tersedia

$sql = "SELECT s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url 
        FROM songs s
        JOIN artists a ON s.artist_id = a.id
        ORDER BY s.id DESC LIMIT 5";

$result = $konek->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trending Songs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      min-height: 100vh;
    }
    .card-container {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .music-card {
      position: relative;
      width: 300px;
      height: 300px;
      border-radius: 25px;
      overflow: hidden;
      background-color: #111;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
      font-family: sans-serif;
      color: white;
    }
    .background-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.6);
    }
    .overlay {
      position: absolute;
      bottom: 20px;
      left: 20px;
      right: 20px;
      background: linear-gradient(to right, #4b2bb3, #2d168f);
      padding: 15px 20px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .song-info h3 {
      margin: 0;
      font-size: 16px;
    }
    .song-info p {
      margin: 5px 0 0;
      font-size: 13px;
      color: #ddd;
    }
    .play-btn {
      width: 40px;
      height: 40px;
      background-color: white;
      color: black;
      border: none;
      border-radius: 50%;
      font-size: 18px;
      cursor: pointer;
    }
  </style>
</head>
<body class="d-flex flex-column">

<div class="px-3">
  <h1>Trending Right Now</h1>

  <div class="card-container">
    <!-- Dynamic Song List -->
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="music-card">
          <img src="<?= htmlspecialchars($row['cover_image_url']) ?>" 
               alt="<?= htmlspecialchars($row['song_title']) ?>" 
               class="background-img">
          <div class="overlay">
            <div class="song-info">
              <h3><?= htmlspecialchars($row['song_title']) ?></h3>
              <p><span class="note-icon">🎵</span> <?= htmlspecialchars($row['artist_name']) ?></p>
            </div>
            <button class="play-btn">▶</button>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-white-50">No trending songs available.</p>
    <?php endif; ?>
  </div>
</div>

<?php $konek->close(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>