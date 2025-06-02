<?php 
$fotoProfile = $_SESSION['foto_profile'] ?? 'upload/default.jpg';
?>
<!-- Sidebar Profile -->
<div id="sidebarProfile" class="position-fixed top-0 end-0 vh-100 text-white p-4 shadow-lg" style="
  width: 280px;
  z-index: 1050;
  transform: translateX(100%);
  transition: transform 0.3s ease;
  background: linear-gradient(180deg, rgba(36,36,62,0.9), rgba(20,20,40,0.95));
  backdrop-filter: blur(12px);
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
">
  <button class="btn-close btn-close-white mb-4" onclick="closeSidebar()"></button>
  
  <!-- Profile Header -->
  <div class="text-center mb-4">
    <img src="upload\default.jpg" alt="Foto Profil" class="rounded-circle shadow" width="80" height="80">
    <h5 class="mt-3 fw-semibold"><?= $_SESSION['username'] ?? 'Guest'; ?></h5>
    <p class="small text-white-50"><?= $_SESSION['email'] ?? ''; ?></p>
  </div>

  <!-- Menu List -->
  <ul class="list-unstyled ps-2">
    <li class="mb-3">
      <a href="favorite.php" class="text-white text-decoration-none d-flex align-items-center">
        <i class="bi bi-heart me-3 fs-5"></i> Favourite
      </a>
    </li>
    <li>
      <a href="logout.php" class="text-white text-decoration-none d-flex align-items-center">
        <i class="bi bi-box-arrow-right me-3 fs-5"></i> Logout
      </a>
    </li>
  </ul>
</div>

<!-- Overlay -->
<div id="overlay" onclick="closeSidebar()" style="
  display:none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  z-index: 1040;
"></div>

<!-- Sidebar Script -->
<script>
function openSidebar() {
  document.getElementById("sidebarProfile").style.transform = "translateX(0)";
  document.getElementById("overlay").style.display = "block";
}
function closeSidebar() {
  document.getElementById("sidebarProfile").style.transform = "translateX(100%)";
  document.getElementById("overlay").style.display = "none";
}
</script>
