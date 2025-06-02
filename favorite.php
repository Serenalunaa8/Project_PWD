<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data lagu favorit user
$sql = "SELECT s.*, a.name AS artist_name 
        FROM favorites f
        JOIN songs s ON f.song_id = s.id
        JOIN artists a ON s.artist_id = a.id
        WHERE f.user_id = ?";
$stmt = $konek->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favorite_count = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StreamBeat - Favorite</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      min-height: 100vh;
    }
    .custom-placeholder::placeholder {
      color: #c4c4c4;
    }
    .playlist-header {
      display: flex;
      align-items: center;
      padding: 20px;
      background: linear-gradient(135deg, #5f2c82, #49a09d);
    }
    .cover-heart {
      width: 150px;
      height: 150px;
      background: linear-gradient(135deg, #4a148c, #303f9f);
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 8px;
    }
    .heart-icon {
      font-size: 50px;
    }
    .playlist-info {
      margin-left: 20px;
    }
    h1 {
      font-size: 48px;
      margin: 5px 0;
    }
    .song-row {
      transition: background-color 0.3s;
      border-radius: 5px;
    }
    .song-row:hover {
      background-color: #2c2c2c;
    }
    .song-number {
      color: #b3b3b3;
      width: 40px;
      text-align: center;
    }
    .song-title {
      flex: 1;
    }
    .song-duration {
      width: 80px;
      text-align: right;
    }
    .favorite-btn {
      background: none;
      border: none;
      color: red;
    }
    footer {
      background-color: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body>
<header class="navbar navbar-expand-lg px-3 py-3" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
  <div class="container-fluid">
    <a class="navbar-brand text-light fw-bold" href="#">🎧 My Music</a>
    <form method="POST" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill" style="max-width: 400px;">
      <i class="bi bi-search me-2"></i>
      <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0 custom-placeholder" name="search_query" placeholder="What do you want to play?" style="flex: 1;">
      <div class="vr mx-3"></div>
      <button class="btn btn-dark p-0" type="submit"><i class="bi bi-archive-fill"></i></button>
    </form>
  </div>
</header>

<main>
  <section class="container py-5">
    <div class="playlist-header rounded-4 p-4 mb-4">
      <div class="cover-heart">
        <div class="heart-icon">❤</div>
      </div>
      <div class="playlist-info">
        <p class="text-uppercase text-white-50 small">Playlist</p>
        <h1>Liked Songs</h1>
        <p class="text-white-50">Cismis • <?= $favorite_count ?> <?= $favorite_count === 1 ? 'song' : 'songs' ?></p>
      </div>
    </div>

    <div class="bg-dark rounded-4 p-3">
      <?php
      $rank = 1;
      if ($favorite_count > 0):
        while ($row = $result->fetch_assoc()):
      ?>
      <div class="song-row d-flex align-items-center py-2 px-3" data-song-id="<?= $row['id'] ?>">
        <div class="song-number"><?= $rank++ ?></div>
        <div class="song-title d-flex align-items-center">
          <button class="favorite-btn me-3" title="Remove from favorites">
            <i class="bi bi-heart-fill fs-5"></i>
          </button>
          <div>
            <div><?= htmlspecialchars($row['title']) ?></div>
            <div class="text-muted small">🎤 <?= htmlspecialchars($row['artist_name']) ?></div>
          </div>
        </div>
        <div class="song-duration">
          <button class="btn btn-sm text-white p-0 play-btn" data-song-url="<?= $row['song_url'] ?>">
            <i class="bi bi-play-circle-fill fs-5"></i>
          </button>
        </div>
      </div>
      <?php endwhile; else: ?>
        <p class="text-center text-white-50">Belum ada lagu favorit.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; z-index: 999;">
  <a href="home.php" class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-house-door-fill active-icon"></i>
  </a>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-search"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-music-note-beamed"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-person"></i></button>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<audio id="audioPlayer" style="display:none;"></audio>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const audio = document.getElementById("audioPlayer");

  // Play button
  document.querySelectorAll(".play-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const url = btn.dataset.songUrl;
      if (audio.src !== url) {
        audio.src = url;
      }
      audio.play();
    });
  });

  // Favorite toggle (unfavorite)
  document.querySelectorAll(".favorite-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const row = btn.closest(".song-row");
      const songId = row.dataset.songId;

      fetch("save_favorite.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "song_id=" + songId
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          row.remove(); // remove dari DOM
        } else {
          alert("Gagal menghapus dari favorit.");
        }
      })
      .catch(err => console.error("Error:", err));
    });
  });
});


</body>
</html>