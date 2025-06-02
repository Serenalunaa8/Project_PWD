<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Semua Lagu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&family=Rowdies:wght@700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: 'Poppins', sans-serif;
    }

    h2 {
      font-family: 'Rowdies', sans-serif;
      font-weight: 700;
      margin-bottom: 24px;
    }

    .song-card {
      background-color: #1e1e3f;
      border-radius: 14px;
      margin-bottom: 16px;
      padding: 14px 20px;
      display: flex;
      align-items: center;
      transition: background-color 0.3s ease;
    }

    .song-card:hover {
      background-color: #302b63;
    }

    .cover-img {
      width: 56px;
      height: 56px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 16px;
      flex-shrink: 0;
    }

    .song-info {
      flex-grow: 1;
      overflow: hidden;
    }

    .song-info h5 {
      margin: 0;
      font-size: 1.05rem;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .song-info small {
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.85rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .play-btn {
      background: white;
      color: #121212;
      border: none;
      font-size: 18px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.2s ease;
    }

    .play-btn:hover {
      transform: scale(1.15);
    }

    audio.audio-player {
      display: none;
    }

    footer.position-fixed {
      width: 90% !important;
      background-color: rgba(255, 255, 255, 0.05) !important;
      backdrop-filter: blur(10px) !important;
      z-index: 999 !important;
    }

    footer .btn-link {
      color: white !important;
    }

    footer .active-icon {
      color: #4b2bb3 !important;
    }
  </style>
</head>
<body>
<main class="container py-4">
    <?php include 'header.php' ?>
  <h2>Daftar Semua Lagu</h2>
  <?php
    $query = "SELECT s.id, s.title, s.song_url, s.cover_image_url, a.name AS artist_name
              FROM songs s
              JOIN artists a ON s.artist_id = a.id
              ORDER BY s.title ASC";
    $result = mysqli_query($konek, $query);
  ?>

  <div class="list-group">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="song-card">
        <img src="<?= $row['cover_image_url'] !== '0' ? htmlspecialchars($row['cover_image_url']) : 'default_cover.png' ?>" class="cover-img" alt="Cover">
        <div class="song-info">
          <h5><?= htmlspecialchars($row['title']) ?></h5>
          <small><?= htmlspecialchars($row['artist_name']) ?></small>
        </div>
        <button class="play-btn">▶</button>
        <audio class="audio-player" src="<?= htmlspecialchars($row['song_url']) ?>"></audio>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<?php include 'footer.php'; ?>

<script>
  // Handle play button logic
  document.addEventListener("DOMContentLoaded", () => {
    const playButtons = document.querySelectorAll('.play-btn');
    const audioPlayers = document.querySelectorAll('.audio-player');
    let currentAudio = null;

    playButtons.forEach((btn, index) => {
      btn.addEventListener('click', () => {
        const player = audioPlayers[index];

        if (currentAudio && currentAudio !== player) {
          currentAudio.pause();
          playButtons.forEach(b => b.textContent = '▶');
        }

        if (player.paused) {
          player.play();
          btn.textContent = '❚❚';
          currentAudio = player;
        } else {
          player.pause();
          btn.textContent = '▶';
          currentAudio = null;
        }
      });
    });
  });
</script>
</body>
</html>
