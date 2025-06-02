<?php
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Ambil daftar lagu favorit pengguna
$lagu_favorit_ids = [];
$query_favorit = $konek->query("SELECT song_id FROM favorites WHERE user_id = $user_id");
while ($row = $query_favorit->fetch_assoc()) {
    $lagu_favorit_ids[] = $row['song_id'];
}

$sql = "SELECT s.id, s.title AS judul_lagu, a.name AS nama_artis, s.cover_image_url, s.song_url, s.play_count
        FROM songs s
        JOIN artists a ON s.artist_id = a.id
        ORDER BY s.play_count DESC
        LIMIT 20";

$result = $konek->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagu Trending</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #121212;
            color: white;
            padding: 20px;
        }
        .item-lagu {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #2f2c5a;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            transition: background-color 0.3s;
        }
      
        .item-lagu:hover {
            background-color: #4b2bb3;
        }
        
        .peringkat-lagu {
            color: #b3b3b3;
            font-weight: bold;
            margin-right: 15px;
            min-width: 25px;
        }
        
        .judul-lagu {
            color: white;
            font-weight: bold;
            margin-bottom: 0;
        }
        
        .playPauseBtn, .favorite-btn {
            background: transparent;
            border: none;
            padding: 0;
        }
        
        .playPauseBtn i {
            color: white;
            font-size: 1.5rem;
        }
        
        .favorite-btn i {
            font-size: 1.2rem;
        }
        
        .favorite-btn .bi-heart-fill {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="my-container">
        <h1>Trending Right Now</h1>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="daftar-lagu">
                <?php 
                $peringkat = 1;
                while ($row = $result->fetch_assoc()): 
                    $id_lagu = $row['id'];
                    $apakah_favorit = in_array($id_lagu, $lagu_favorit_ids);
                ?>
                    <div class="item-lagu">
                        <div class="d-flex align-items-center">
                            <span class="peringkat-lagu"><?= sprintf('%02d', $peringkat) ?></span>
                            <img src="<?= htmlspecialchars($row['cover_image_url']) ?>" alt="Sampul" class="me-3 rounded-3" width="48" height="48">
                            <div class="flex-grow-1">
                                <p class="judul-lagu"><?= htmlspecialchars($row['judul_lagu']) ?></p>
                                <small class="text-white-50"><?= htmlspecialchars($row['nama_artis']) ?></small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <small class="text-white-50 me-2"><?= number_format($row['play_count']) ?></small>
                            <button class="playPauseBtn" data-song-url="<?= htmlspecialchars($row['song_url']) ?>" data-song-id="<?= $id_lagu ?>">
                                <i class="bi bi-play-circle-fill"></i>
                            </button>
                            <button class="favorite-btn" data-song-id="<?= $id_lagu ?>">
                                <i class="bi <?= $apakah_favorit ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                            </button>
                        </div>
                    </div>
                <?php 
                    $peringkat++;
                endwhile; 
                ?>
            </div>
        <?php else: ?>
            <p>Tidak ada lagu trending.</p>
        <?php endif; ?>
    </div>

    <audio id="pemutarAudio" style="display:none;"></audio>

    <script src="audio_player.js"></script>
</body>
</html>