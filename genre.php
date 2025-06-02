<?php
include 'koneksi.php';
$genre_name = $_GET['genre'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $genre_name ? "Genre: $genre_name" : "Genres" ?> - Music Streaming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      font-family: 'Poppins', sans-serif;
    }
    .genre-card {
      height: 180px;
      background-size: cover;
      background-position: center;
      border-radius: 1rem;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease;
      display: flex;
      align-items: flex-end;
    }
    .genre-card:hover {
      transform: scale(1.03);
    }
    .genre-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.2));
      z-index: 1;
    }
    .genre-card .card-body {
      position: relative;
      z-index: 2;
      padding: 1rem;
      width: 100%;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container py-5">
  <h1 class="text-center mb-4">🎵 Explore Genres</h1>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    $query = "SELECT name FROM genres ORDER BY name ASC";
    $result = mysqli_query($konek, $query);
    while ($genre = mysqli_fetch_assoc($result)):
      $genreName = htmlspecialchars($genre['name']);
      $lowerName = strtolower(str_replace(' ', '', $genreName));
      $imagePath = file_exists("asset/{$lowerName}.jpg") ? "asset/{$lowerName}.jpg" : "asset/default-genre.jpg";
    ?>
    <div class="col">
      <a href="genreLagu.php?genre=<?= urlencode($genreName); ?>" style="text-decoration: none;">
        <div class="card genre-card text-white" style="background-image: url('<?= $imagePath ?>');">
          <div class="card-body">
            <h5 class="card-title"><?= $genreName ?></h5>
            <p class="card-text">Explore <?= $genreName ?> hits for your vibe.</p>
          </div>
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
