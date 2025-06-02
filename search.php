<?php
include 'koneksi.php';
include 'header.php';

if (!isset($_POST['search_query'])) {
    header("Location: home.php");
    exit();
}
$search = $_POST['search_query'];

if ($search === '') {
    header("Location: home.php");
    exit();
}

$sql = "SELECT s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url, s.id 
        FROM songs s
        JOIN artists a ON s.artist_id = a.id
        WHERE s.title LIKE ? OR a.name LIKE ?";

$stmt = $konek->prepare($sql);
$param = '%' . $search . '%';
$stmt->bind_param('ss', $param, $param);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
.search-container {
  padding: 100px 20px 60px;
  color: white;
  max-width: 1000px;
  margin: 0 auto;
}

.search-header {
  font-weight: 600;
  margin-bottom: 1.5rem;
  text-align: center;
}

.search-divider {
  border-color: #6c5ce7;
  opacity: 0.3;
}

.song-result {
  background-color: #2b2b4a;
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 24px;
  min-height: 140px;
  transition: transform 0.2s;
  display: flex;
  gap: 20px;
  align-items: center;
}

.song-result:hover {
  transform: translateY(-3px);
  background-color: #343458;
}

.song-cover {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
}

.song-info {
  flex: 1;
}

.song-title {
  font-weight: 600;
  margin-bottom: 6px;
  color: white;
  font-size: 1.2rem;
}

.song-artist {
  color: #b3b3b3;
  font-size: 0.95rem;
}

.audio-player {
  width: 100%;
  margin-top: 14px;
}

.audio-player::-webkit-media-controls-panel {
  background-color: #1e1e3f;
}

.no-results {
  color: #ff9e43;
  text-align: center;
  padding: 3rem 0;
}

.recommendations-title {
  color: white;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
  text-align: center;
}
</style>

<div class="search-container">
  <h3 class="search-header">Hasil Pencarian: "<?= htmlspecialchars($search) ?>"</h3>
  <hr class="search-divider">

  <?php if (isset($result) && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="d-flex align-items-center song-result">
        <img src="<?= htmlspecialchars($row['cover_image_url']) ?: 'asset/default.jpg' ?>" class="song-cover" alt="cover">
        <div class="song-info">
          <h5 class="song-title"><?= htmlspecialchars($row['song_title']) ?></h5>
          <br><br>
          <p class="song-artist mb-2"><?= htmlspecialchars($row['artist_name']) ?></p>
          <audio controls class="audio-player">
            <source src="<?= htmlspecialchars($row['song_url']) ?>" type="audio/mpeg">
            Browser tidak mendukung audio.
          </audio>
        </div>
      </div>
    <?php endwhile; ?>

  <?php else: ?>
    <div class="no-results">
      <i class="bi bi-search" style="font-size: 2rem;"></i>
      <h5 class="mt-3">Lagu tidak ditemukan</h5>
      <p>Coba kata kunci lain atau lihat rekomendasi kami</p>
    </div>

    <h5 class="recommendations-title">Rekomendasi Lagu:</h5>
    <hr class="search-divider">
    
    <?php
      $rekSql = "SELECT s.title AS song_title, a.name AS artist_name, s.cover_image_url, s.song_url 
                FROM songs s
                JOIN artists a ON s.artist_id = a.id
                ORDER BY RAND() LIMIT 5";
      $rekResult = $konek->query($rekSql);
      while ($rek = $rekResult->fetch_assoc()):
    ?>
      <div class="d-flex align-items-center song-result">
        <img src="<?= htmlspecialchars($rek['cover_image_url']) ?: 'asset/default.jpg' ?>" class="song-cover" alt="cover">
        <div class="song-info">
          <h5 class="song-title"><?= htmlspecialchars($rek['song_title']) ?></h5>
          <p class="song-artist mb-2"><?= htmlspecialchars($rek['artist_name']) ?></p>
          <audio controls class="audio-player">
            <source src="<?= htmlspecialchars($rek['song_url']) ?>" type="audio/mpeg">
          </audio>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php
include 'footer.php';
if (isset($stmt)) $stmt->close();
$konek->close();
?>