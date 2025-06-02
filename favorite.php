<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

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
  <title>StreamBeat - Favorite</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #1f1f3a, #2b2b4a);
      color: white;
      min-height: 100vh;
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
<body data-user-id="<?= $user_id ?>">

<?php include 'header.php'; ?>

<br>
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
      <div class="song-row d-flex align-items-center py-2 px-3">
        <div class="song-number"><?= $rank++ ?></div>
        <div class="song-title d-flex align-items-center">
          <button class="favorite-btn me-3" title="Remove from favorites" data-song-id="<?= $row['id'] ?>" data-user-id="<?= $user_id ?>">
            <i class="bi bi-heart-fill fs-5 text-danger"></i>
          </button>
          <div>
            <div><?= htmlspecialchars($row['title']) ?></div>
            <div class="text-muted small">🎤 <?= htmlspecialchars($row['artist_name']) ?></div>
          </div>
        </div>
        <div class="song-duration">
          <button class="btn btn-sm text-white p-0 playPauseBtn" 
                  data-song-url="<?= htmlspecialchars($row['song_url']) ?>"
                  data-song-id="<?= $row['id'] ?>">
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

<?php include 'footer.php'; ?>

<script>
// Fungsi untuk menginisialisasi pemutar audio
function initAudioPlayer() {
    const audioPlayer = new Audio();
    audioPlayer.style.display = 'none';
    document.body.appendChild(audioPlayer);
    
    let currentButton = null;
    let currentSongId = null;

    // Fungsi untuk menangani play/pause
    function handlePlayPause(button, songUrl, songId, userId) {
        const icon = button.querySelector('i');
        
        // Jika lagu yang sama diklik
        if (currentSongId === songId) {
            if (audioPlayer.paused) {
                audioPlayer.play();
                icon.classList.replace('bi-play-circle-fill', 'bi-pause-circle-fill');
            } else {
                audioPlayer.pause();
                icon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
            }
            return;
        }

        // Jika lagu baru diklik
        if (currentButton) {
            const prevIcon = currentButton.querySelector('i');
            prevIcon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
        }

        audioPlayer.src = songUrl;
        audioPlayer.play();
        icon.classList.replace('bi-play-circle-fill', 'bi-pause-circle-fill');
        
        // Simpan riwayat pemutaran
        savePlayHistory(songId, userId);
        
        currentButton = button;
        currentSongId = songId;
    }

    // Event ketika audio selesai
    audioPlayer.addEventListener('ended', () => {
        if (currentButton) {
            const icon = currentButton.querySelector('i');
            icon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
        }
        currentSongId = null;
        currentButton = null;
    });

    return {
        handlePlayPause
    };
}

// Fungsi untuk menyimpan riwayat pemutaran
function savePlayHistory(songId, userId) {
    if (!songId || !userId) return;
    
    fetch("save_play_history.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id_lagu=${songId}&id_pengguna=${userId}`
    }).catch(err => console.error('Gagal menyimpan riwayat:', err));
}

// Fungsi untuk menangani favorit
function initFavoriteButtons() {
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', function() {
            const songId = this.dataset.songId;
            const userId = this.dataset.userId;
            const icon = this.querySelector('i');
            
            fetch("save_favorite.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `song_id=${songId}&user_id=${userId}`
            })
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');
                    icon.classList.toggle('text-danger');
                    // Optionally remove the song row from UI
                    if (data.action === 'removed') {
                        this.closest('.song-row').remove();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
}

// Inisialisasi ketika DOM siap
document.addEventListener('DOMContentLoaded', () => {
    const audioPlayer = initAudioPlayer();
    const userId = document.body.dataset.userId;
    
    // Atur event listener untuk tombol play
    document.querySelectorAll('.playPauseBtn').forEach(button => {
        button.addEventListener('click', function() {
            audioPlayer.handlePlayPause(
                this,
                this.dataset.songUrl,
                this.dataset.songId,
                userId
            );
        });
    });
    
    // Inisialisasi tombol favorit
    initFavoriteButtons();
});
</script>
</body>
</html>