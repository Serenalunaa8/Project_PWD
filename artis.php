<?php
session_start();
include 'koneksi.php';

$hero_query = mysqli_query($konek, "
  SELECT a.*, SUM(s.play_count) AS total_play, s.title AS top_song, s.song_url, s.cover_image_url
  FROM artists a
  JOIN songs s ON s.artist_id = a.id
  GROUP BY a.id
  ORDER BY total_play DESC
  LIMIT 1
");

$hero = mysqli_fetch_assoc($hero_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Streaming - Artists</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      min-height: 100vh;
    }

    h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.8rem;
    }

    .playlist-card {
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .playlist-card:hover {
      transform: scale(1.05);
    }

    .card-img {
      object-fit: cover;
      height: 100%;
    }

    footer {
      background-color: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body class="d-flex flex-column">

<!-- Header -->
<header class="navbar navbar-expand-lg px-3 py-3" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
  <div class="container-fluid">
    <a class="navbar-brand text-light fw-bold" href="#">🎧 My Music</a>
    <form method="POST" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill" style="max-width: 400px;">
      <i class="bi bi-search me-2"></i>
      <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0" name="search_query" placeholder="What do you want to play?" style="flex: 1;">
      <div class="vr mx-3"></div>
      <button class="btn btn-dark p-0" type="submit">
        <i class="bi bi-archive-fill"></i>
      </button>
    </form>
  </div>
</header>

<!-- Hero Section -->
<section class="container py-5">
  <div class="rounded-4 d-flex flex-column flex-md-row align-items-center p-4" 
       style="background: linear-gradient(to right, #4b2bb3, #2d168f);">
    <div class="flex-grow-1">
      <h5 class="text-white mb-2"><?= htmlspecialchars($hero['name']) ?></h5>
      <h2 class="text-white fw-bold mb-3"><?= htmlspecialchars($hero['top_song']) ?></h2>
      <button class="btn btn-light rounded-pill px-4" onclick="document.getElementById('heroAudio').play();">
        ▶️ Listen now
      </button>
      <audio id="heroAudio" style="display: none;">
      <source src="<?= htmlspecialchars($hero['song_url']) ?>" type="audio/mpeg">
      </audio>
    </div>
    <img src="<?= file_exists($hero['image_url']) ? $hero['image_url'] : 'asset/default.jpg' ?>"
         class="img-fluid ms-md-4 mt-4 mt-md-0"
         alt="<?= htmlspecialchars($hero['name']) ?>"
         style="max-height: 200px; border-radius: 1rem;">
  </div>
</section>


<!-- Popular Artists -->
<main class="container pb-5 flex-grow-1">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="text-start">Popular Artists</h1>
    <a href="#" class="text-decoration-none text-light">View All</a>
  </div>

  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-4">
    <?php
    $query = mysqli_query($konek, "SELECT a.*, 
        (SELECT COUNT(*) FROM songs s WHERE s.artist_id = a.id) AS total_songs 
        FROM artists a ORDER BY name ASC");

    while ($row = mysqli_fetch_assoc($query)):
      $id = $row['id'];
      $name = htmlspecialchars($row['name']);
      $img = file_exists($row['image_url']) ? $row['image_url'] : 'asset/default.jpg';
      $tracks = $row['total_songs'];
    ?>
    <div class="col">
      <div class="card bg-dark text-white border-0 rounded-4 overflow-hidden h-100 playlist-card position-relative" onclick="window.location.href='tampilan_artis.php?id=<?= $id ?>'">
        <img src="<?= $img ?>" class="card-img h-100" alt="<?= $name ?>">
        <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
          <h5 class="card-title mb-0 fw-bold"><?= $name ?></h5>
          <p class="card-text small"><?= $tracks ?> Tracks</p>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</main>

<!-- Footer -->
<footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; z-index: 999;">
  <button class="btn btn-link text-white fs-5 p-0">
    <a href="home.php" class="text-white text-decoration-none">
      <i class="bi bi-house-door-fill active-icon"></i>
    </a>
  </button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-search"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-music-note-beamed"></i></button>
  <button class="btn btn-link text-white fs-5 p-0"><i class="bi bi-person"></i></button>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>