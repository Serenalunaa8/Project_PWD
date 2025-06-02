<?php
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$artist_ids = [];
$q1 = "SELECT s.artist_id 
       FROM play_history ph
       JOIN songs s ON ph.song_id = s.id 
       WHERE ph.user_id = '$user_id'  
       GROUP BY s.artist_id
       ORDER BY COUNT(*) DESC
       LIMIT 3";
$res1 = mysqli_query($konek, $q1);
if ($res1) {
    while ($row = mysqli_fetch_assoc($res1)) {
        $artist_ids[] = (int)$row['artist_id'];
    }
} else {
    // Debugging: tampilkan error jika query gagal
    echo "<p style='color:red'>Query error: " . mysqli_error($konek) . "</p>";
}

if (empty($artist_ids)) {
    $sql = "SELECT s.id, s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url
            FROM songs s
            JOIN artists a ON s.artist_id = a.id
            ORDER BY s.play_count DESC
            LIMIT 3";
    $result = mysqli_query($konek, $sql);
} else {
    // Query lagu dari artist yang sering diputar user
    $ids_str = implode(',', $artist_ids);  // convert array ke string untuk IN clause
    $sql = "SELECT s.id, s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url
            FROM songs s
            JOIN artists a ON s.artist_id = a.id
            WHERE s.artist_id IN ($ids_str)
            ORDER BY s.play_count DESC
            LIMIT 3";
    $result = mysqli_query($konek, $sql);

    if (!$result) {
        echo "<p style='color:red'>Query error: " . mysqli_error($konek) . "</p>";
    }
}

?>

<!-- HTML presentation remains unchanged -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekomendasi Lagu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
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

    .music-card img {
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
      flex-direction: column;
    }

    .overlay h5, .overlay p {
      margin: 0;
      text-align: center;
    }

    .play-btn {
      margin-top: 10px;
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

<body class="bg-dark text-white p-5">
  <h2>Made For <?= htmlspecialchars($username) ?></h2>
  <div class="card-container">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="music-card">
          <img src="<?= htmlspecialchars($row['cover_image_url']) ?>" alt="cover">
          <div class="overlay">
            <h5><?= htmlspecialchars($row['song_title']) ?></h5>
            <p><?= htmlspecialchars($row['artist_name']) ?></p>
            <button class="play-btn">▶</button>
            <audio class="audio-player" src="<?= htmlspecialchars($row['song_url']) ?>" data-song-id="<?= $row['id'] ?>"></audio>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Tidak ada data rekomendasi.</p>
    <?php endif; ?>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const playButtons = document.querySelectorAll('.play-btn');
      const audioPlayers = document.querySelectorAll('.audio-player');
      let current = null;

      playButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
          const player = audioPlayers[index];

          if (current && current !== player) {
            current.pause();
            playButtons.forEach(b => b.textContent = '▶');
          }

          if (player.paused) {
            player.play();
            btn.textContent = '❚❚';
            const songId = player.dataset.songId;

            fetch("save_play_history.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded"
              },
              body: `song_id=${songId}&user_id=<?= $user_id ?>`
            });

            current = player;
          } else {
            player.pause();
            btn.textContent = '▶';
            current = null;
          }
        });
      });
    });
  </script>
</body>
</html>
