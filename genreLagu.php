<?php
include 'koneksi.php';
$genre_name = $_GET['genre'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($genre_name); ?> Songs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #1e1e3f;
      color: white;
      font-family: 'Poppins', sans-serif;
      padding: 40px 0;
    }
    .song-card {
      background-color: #2b2b4a;
      border-radius: 12px;
      padding: 16px;
      display: flex;
      align-items: center;
      margin-bottom: 16px;
    }
    .song-cover {
      width: 50px;
      height: 50px;
      border-radius: 6px;
      object-fit: cover;
      margin: 0 12px;
    }
    .song-meta {
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: left;
    }
    .song-title {
      font-weight: 600;
      margin: 0;
      color: #fff;
      font-size: 1rem;
    }
    .song-artist {
      font-size: 0.85rem;
      color: #ccc;
    }
    .song-playcount {
      font-size: 0.9rem;
      font-weight: 500;
      color: #ccc;
    }
    .song-actions {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-top: 4px;
    }
    .song-actions i {
      font-size: 1.2rem;
      color: white;
      cursor: pointer;
      margin-left: 12px;
    }
    .rank-number {
      font-weight: bold;
      width: 32px;
      text-align: center;
    }
  </style>
</head>
<body data-user-id="<?= $_SESSION['user_id'] ?? 0 ?>">
<?php include "header.php"; ?>
<div class="container">
  <a href="genre.php" class="btn btn-outline-light mb-3">&larr; Kembali ke Genre</a>
  <h2 class="mb-4">Genre: <?= htmlspecialchars($genre_name); ?></h2>

  <?php
  $sql = "
    SELECT songs.*, artists.name AS artist_name
    FROM songs
    JOIN song_genres ON songs.id = song_genres.song_id
    JOIN genres ON song_genres.genre_id = genres.id
    LEFT JOIN artists ON songs.artist_id = artists.id
    WHERE LOWER(genres.name) = LOWER(?)
    ORDER BY songs.play_count DESC
  ";
  $stmt = $konek->prepare($sql);
  $stmt->bind_param("s", $genre_name);
  $stmt->execute();
  $result = $stmt->get_result();
  $rank = 1;

  if ($result->num_rows === 0) {
    echo "<p class='text-center'>Belum ada lagu untuk genre <strong>$genre_name</strong>.</p>";
  }

  while ($song = $result->fetch_assoc()):
    $cover = (!empty($song['cover_image_url']) && $song['cover_image_url'] !== '0') ? $song['cover_image_url'] : 'asset/default.jpg';
    $title = $song['title'];
    $artist = $song['artist_name'] ?? 'Unknown Artist';
    $playCount = number_format($song['play_count'], 0, ',', '.');
  ?>
  <div class="song-card">
    <div class="rank-number"><?= str_pad($rank++, 2, '0', STR_PAD_LEFT); ?></div>
    <img src="<?= $cover ?>" alt="Cover" class="song-cover" />
    <div class="song-meta flex-grow-1">
      <p class="song-title mb-0"><?= $title ?></p>
      <span class="song-artist"><?= $artist ?></span>
    </div>
    <div class="text-end text-nowrap">
      <div class="song-playcount"><?= $playCount ?></div>
      <div class="song-actions">
        <button class="btn btn-sm text-white playPauseBtn"
                data-song-url="<?= $song['song_url'] ?>"
                data-song-id="<?= $song['id'] ?>">
          <i class="bi bi-play-circle-fill"></i>
        </button>
        <button class="btn btn-sm text-white favorite-btn"
                data-song-id="<?= $song['id'] ?>"
                data-user-id="<?= $_SESSION['user_id'] ?? 0 ?>">
          <i class="bi bi-heart"></i>
        </button>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>
<?php include "footer.php"; ?>
<script src="audio_player.js"></script>
</body>
</html>
