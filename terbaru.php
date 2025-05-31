<?php
include 'koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT s.id, s.title AS judul_lagu, a.name AS nama_artis, s.cover_image_url, s.song_url, s.created_at
        FROM songs s
        JOIN artists a ON s.artist_id = a.id
        ORDER BY s.created_at DESC
        LIMIT 10";
$result = $konek->query($sql);

// Ambil daftar lagu favorit pengguna
$lagu_favorit_ids = [];
$query_favorit = $konek->query("SELECT song_id FROM favorites WHERE user_id = $user_id");
while ($row = $query_favorit->fetch_assoc()) {
    $lagu_favorit_ids[] = $row['song_id'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lagu Terbaru</title>
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
    </style>
</head>
<body>
    <div class="container">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="daftar-lagu">
                <?php 
                $peringkat = 1;
                while ($row = $result->fetch_assoc()): 
                    $id_lagu = $row['id'];
                    $apakah_favorit = in_array($id_lagu, $lagu_favorit_ids);
                ?>
                    <div class="item-lagu d-flex align-items-center">
                        <span class="peringkat-lagu"><?= sprintf('%02d', $peringkat) ?></span>
                        <img src="<?= htmlspecialchars($row['cover_image_url']) ?>" alt="Sampul" class="me-3 rounded-3" width="48" height="48">
                        <div class="info-lagu flex-grow-1">
                            <p class="judul-lagu mb-0"><?= htmlspecialchars($row['judul_lagu']) ?></p>
                            <small class="text-white-50"><?= htmlspecialchars($row['nama_artis']) ?></small>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <!-- Tombol Putar -->
                            <button class="btn btn-sm p-0 tombolPlay" data-url-lagu="<?= htmlspecialchars($row['song_url']) ?>" data-id-lagu="<?= $id_lagu ?>">
                                <i class="bi bi-play-circle-fill fs-4" style="color: #fff;"></i>
                            </button>
                            
                            <!-- Tombol Favorit -->
                            <button class="btn btn-sm text-white p-0 tombolFavorit" data-id-lagu="<?= $id_lagu ?>">
                                <i class="bi <?= $apakah_favorit ? 'bi-heart-fill text-danger' : 'bi-heart' ?> fs-5"></i>
                            </button>
                            
                            <!-- Menu Lainnya -->
                            <button class="btn btn-link text-white p-0">
                                <i class="bi bi-three-dots"></i>
                            </button>
                        </div>
                    </div>
                <?php 
                    $peringkat++;
                endwhile; 
                ?>
            </div>
        <?php else: ?>
            <p>Tidak ada lagu terbaru.</p>
        <?php endif; ?>
    </div>

    <audio id="pemutarAudio"></audio>

    <script>
        const pemutarAudio = document.getElementById("pemutarAudio");
        let tombolSekarang = null;
        let idLaguSekarang = null;

        document.querySelectorAll(".tombolPlay").forEach(tombol => {
            tombol.addEventListener("click", function() {
                const urlLagu = this.dataset.urlLagu;
                const idLagu = this.dataset.idLagu;
                const ikon = this.querySelector("i");

                // Jika lagu yang sama diklik
                if (idLaguSekarang === idLagu) {
                    if (pemutarAudio.paused) {
                        pemutarAudio.play();
                        ikon.classList.replace("bi-play-circle-fill", "bi-pause-circle-fill");
                    } else {
                        pemutarAudio.pause();
                        ikon.classList.replace("bi-pause-circle-fill", "bi-play-circle-fill");
                    }
                    return;
                }

                // Lagu baru diklik
                if (tombolSekarang) {
                    const ikonSebelumnya = tombolSekarang.querySelector("i");
                    ikonSebelumnya.classList.replace("bi-pause-circle-fill", "bi-play-circle-fill");
                }

                pemutarAudio.src = urlLagu;
                pemutarAudio.play();
                ikon.classList.replace("bi-play-circle-fill", "bi-pause-circle-fill");
                
                // Simpan riwayat pemutaran
                fetch("simpan_riwayat_putar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id_lagu=${idLagu}&id_pengguna=<?= $user_id ?>`
                });

                tombolSekarang = this;
                idLaguSekarang = idLagu;
            });
        });

        pemutarAudio.addEventListener("ended", () => {
            if (tombolSekarang) {
                const ikon = tombolSekarang.querySelector("i");
                ikon.classList.replace("bi-pause-circle-fill", "bi-play-circle-fill");
            }
            idLaguSekarang = null;
            tombolSekarang = null;
        });

        // Fungsi tombol favorit
        document.querySelectorAll(".tombolFavorit").forEach(tombol => {
            tombol.addEventListener("click", function() {
                const idLagu = this.dataset.idLagu;
                const ikon = this.querySelector("i");
                
                fetch("simpan_favorit.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id_lagu=${idLagu}&id_pengguna=<?= $user_id ?>`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sukses) {
                        ikon.classList.toggle("bi-heart");
                        ikon.classList.toggle("bi-heart-fill");
                        ikon.classList.toggle("text-danger");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            });
        });
    </script>
</body>
</html>