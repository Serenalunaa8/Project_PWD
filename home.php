<?php 
session_start(); 
$user_id = $_SESSION['user_id'] ?? null;
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include 'koneksi.php';
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$_SESSION['user_id'] = $user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Streaming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
    <style>
      .trending-section {
        background-color: #1e1e3f;
        padding: 20px;
        border-radius: 12px;
      }

      .recommendation-section {
        background-color: #1e1e3f;
        padding: 20px;
         border-radius: 12px;
      }

    </style>
</head>
<body class="d-flex flex-column">
  <!-- Header -->
  <header class="navbar navbar-expand-lg px-3 py-3" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
    <div class="container-fluid">
      <!-- Logo / Brand -->
      <a class="navbar-brand text-light fw-bold" href="#">
        🎧 My Melodist
      </a>
  
       <!-- garis 3 ketika layar diperkecil -->
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      
    <!-- Search Bar -->
    <form method="POST" action="search.php" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill" style="max-width: 400px;">
    <i class="bi bi-search me-2"></i>
    <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0 custom-placeholder" name="search_query" placeholder="What do you want to play?" style="flex: 1;">
    <div class="vr mx-3"></div>
    <button class="btn btn-dark p-0" type="submit">
        <i class="bi bi-archive-fill"></i>
    </button>
    </form>
</header>
<br>
  <section class="px-3">
    <?php include 'recomend.php'; ?>
  </section>

  <!-- Category Tabs -->
<nav class="px-3 mb-3 d-flex gap-2 flex-wrap">
  <button class="tab-button active">Trending</button>
  <a href="genre.php" class="tab-button">Genre</a>
  <a href="albums.php" class="tab-button">Albums</a>
   <a href="favorite.php" class="tab-button">Favorite</a>
</nav>

<!-- trending list -->
<div class="d-flex flex-wrap gap-4 px-3" style="align-items: flex-start;">
  <div class="trending-section flex-grow-1" style="min-width: 55%;">
    <?php include 'tren.php'; ?>
  </div>
    
  <div class="recommendation-section" style="min-width: 40%;">
    <h2>Recommended For You</h2>
    <div class="recommendation-songs d-flex flex-column gap-2">
      <?php include 'terbaru.php'; ?>
    </div>


  <!-- Bottom Navigation -->
<footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; background-color: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); z-index: 999;">
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-house-door-fill active-icon"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-search"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-music-note-beamed"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-person"></i>
  </button>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<audio id="audioPlayer" style="display:none;"></audio>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const audio = document.getElementById("audioPlayer");

    document.querySelectorAll(".play-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const url = btn.dataset.songUrl;
        const songId = btn.dataset.songId;
        const userId = <?= json_encode($_SESSION['user_id'] ?? null); ?>;

        if (audio.src !== url) {
          audio.src = url;
        }
        audio.play();

        // Simpan riwayat
        if (userId && songId) {
          fetch("save_play_history.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/x-www-form-urlencoded"
  },
  body: `song_id=${songId}`
});

          .then(res => res.text())
          .then(res => console.log("History saved:", res));
        }
      });
    });
  });
</script>

</body>
</html>
