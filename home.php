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

    body {
      font-family: 'dm-serif-display-regular', sans-serif;
      background-color: #121212;
      color: white;
    }

    h1, h2, h3, h4, .navbar-brand {
      font-family: 'Rowdies', sans-serif;
      font-weight: 700;
    }

    .tab-button {
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      padding: 8px 16px;
      border: none;
      background-color: #2c2c54;
      color: white;
      border-radius: 8px;
      transition: background-color 0.2s ease;
    }

    .tab-button:hover, .tab-button.active {
      background-color: #6c5ce7;
    }

    .trending-section, .recommendation-section {
      font-family: 'Poppins', sans-serif;
    }

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
  <?php include 'header.php' ?>
 
  <section class="px-3" style="margin-top: 80px;">
    <?php include 'recomend.php'; ?>
  </section>
  <br><br><br>

  <!-- Category Tabs -->
<nav class="px-3 mb-3 d-flex gap-2 flex-wrap">
  <button class="tab-button active">Trending</button>
  <a href="genre.php" class="tab-button">Genre</a>
  <a href="artis.php" class="tab-button">Artist</a>
   <a href="favorite.php" class="tab-button">Favorite</a>
</nav>

<!-- trending list -->
<div class="d-flex flex-wrap gap-4 px-3" style="align-items: flex-start;">
  <div class="trending-section flex-grow-1" style="min-width: 50%;">
    <?php include 'tren.php'; ?>
  </div>
    
  <div class="recommendation-section" style="min-width: 45%;">
    <h2>What's New?</h2>
    <div class="recommendation-songs d-flex flex-column gap-2">
      <?php include 'terbaru.php'; ?>
    </div>

  <?php include 'profile_sidebar.php'?>
  <!-- Bottom Navigation -->
  <?php include 'footer.php'; ?>
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
  }co radist
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