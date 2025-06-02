<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id'] ?? 0;
$artist_id = $_GET['id'] ?? null;

if (!$artist_id) {
    echo "ID artis tidak ditemukan.";
    exit;
}

$artis = mysqli_fetch_assoc(mysqli_query($konek, "SELECT * FROM artists WHERE id = $artist_id"));
if (!$artis) {
    echo "Artis tidak ditemukan.";
    exit;
}

$lagu_query = mysqli_query($konek, "SELECT * FROM songs WHERE artist_id = $artist_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($artis['name']) ?> - Lagu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      padding-bottom: 100px;
    }
    .artist-info {
      background: linear-gradient(to right, #4b2bb3, #2d168f);
      padding: 30px;
      border-radius: 20px;
      display: flex;
      gap: 20px;
      align-items: center;
      margin-bottom: 40px;
    }
    .artist-info img {
      width: 200px;
      height: 200px;
      border-radius: 15px;
      object-fit: cover;
      border: 3px solid rgba(255, 255, 255, 0.3);
    }
    .song-card {
      background-color: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .song-card .song-title {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .song-card img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 10px;
    }
    .btn-icon {
      background: none;
      border: none;
      color: white;
      font-size: 1.4rem;
      margin-left: 10px;
    }
  </style>
</head>
<body data-user-id="<?= $user_id ?>" class="container py-5">

  <!-- Artist Header -->
  <div class="artist-info">
    <?php if (!empty($artis['image_url']) && file_exists($artis['image_url'])): ?>
      <img src="<?= $artis['image_url'] ?>" alt="<?= htmlspecialchars($artis['name']) ?>">
    <?php endif; ?>
    <div>
      <h1><?= htmlspecialchars($artis['name']) ?></h1>
      <p><?= nl2br(htmlspecialchars($artis['bio'])) ?></p>
    </div>
  </div>

  <h2 class="mb-4">🎵 Lagu <?= htmlspecialchars($artis['name']) ?></h2>

  <!-- Song List -->
  <?php while ($lagu = mysqli_fetch_assoc($lagu_query)): ?>
    <div class="song-card">
      <div class="song-title">
        <?php if ($lagu['cover_image_url'] !== '0' && file_exists($lagu['cover_image_url'])): ?>
          <img src="<?= $lagu['cover_image_url'] ?>" alt="Cover">
        <?php endif; ?>
        <span><?= htmlspecialchars($lagu['title']) ?></span>
      </div>
      <div>
        <button class="btn-icon playPauseBtn"
                data-song-id="<?= $lagu['id'] ?>"
                data-song-url="<?= $lagu['song_url'] ?>">
          <i class="bi bi-play-circle-fill"></i>
        </button>
        <button class="btn-icon favorite-btn"
                data-song-id="<?= $lagu['id'] ?>"
                data-user-id="<?= $user_id ?>">
          <i class="bi bi-heart"></i>
        </button>
      </div>
    </div>
  <?php endwhile; ?>

   <!-- Bottom Navigation -->
<!-- Footer -->
<footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; z-index: 999;">
  <button class="btn btn-link text-white fs-5 p-0">
    <a href="artis.php" class="text-white text-decoration-none">
      <i class="bi bi-house-door-fill active-icon"></i>
    </a>
  </button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-search"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-music-note-beamed"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-person"></i></button>
</footer>

  <script src="audio_player.js"></script>
</body>
</html>