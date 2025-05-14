<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Streaming - Trending</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
    
</head>
<body class="d-flex flex-column">
  <!-- Header -->
  <header class="navbar navbar-expand-lg px-3 py-3" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
    <div class="container-fluid">
      <!-- Logo / Brand -->
      <a class="navbar-brand text-light fw-bold" href="#">
        🎧 StreamBeat
      </a>
  
       <!-- garis 3 ketika layar diperkecil -->
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      
    <!-- Search Bar -->
    <form method="POST" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill" style="max-width: 400px;">
    <i class="bi bi-search me-2"></i>
    <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0 custom-placeholder" name="search_query" placeholder="What do you want to play?" style="flex: 1;">
    <div class="vr mx-3"></div>
    <button class="btn btn-dark p-0" type="submit">
        <i class="bi bi-archive-fill"></i>
    </button>
</form>

  </header>
  <br>

  <section class="px-3">
    <?php include 'tren.php'; ?>
  </section>

  <!-- Category Tabs -->
  <nav class="px-3 mb-3 scroll-x">
    <button class="btn btn-sm btn-dark rounded-pill">Trending</button>
    <button class="btn btn-sm btn-secondary rounded-pill"><a href="genre.php" class="text-white text-decoration-none">Genre</a></button>
    <button class="btn btn-sm btn-secondary rounded-pill">Albums</button>
    <button class="btn btn-sm btn-secondary rounded-pill">Favorite</button>
  </nav>

 <!-- Song List -->
<main class="flex-grow-1 px-3 overflow-auto">
  <h1 class="mb-4">Trending right now</h1>

  <!-- Song Item -->
  <div class="d-flex justify-content-between align-items-center mb-3">
     <div class="d-flex align-items-center">
      <span class="me-3 fw-bold text-white-50">01</span>
      <img src="asset/darkside.jpg" alt="" class="me-3 rounded-3" width="48" height="48">
      <div>
        <p class="mb-0">I'm Good (Blue)</p>
        <small class="text-white-50">David Guetta & Bebe Rexha</small>
      </div>
    </div>
    <div class="d-flex align-items-center gap-5">
      <small class="text-white-50 me-3">03:29</small>
      <small class="text-white-50 me-3">8 078 651</small>
      <i class="bi bi-heart me-3"></i>
      <i class="bi bi-three-dots"></i>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
      <span class="me-3 fw-bold text-white-50">02</span>
      <img src="asset/under.jpg" alt="" class="me-3 rounded-3" width="48" height="48">
      <div>
        <p class="mb-0">Under the Influence</p>
        <small class="text-white-50">Chris Brown</small>
      </div>
    </div>
    <div class="d-flex align-items-center gap-5">
      <small class="text-white-50 me-3">03:04</small>
      <small class="text-white-50 me-3">2 341 221</small>
      <i class="bi bi-heart me-3"></i>
      <i class="bi bi-three-dots"></i>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
      <span class="me-3 fw-bold text-white-50">03</span>
      <img src="asset/forgetme.jpg" alt="" class="me-3 rounded-3" width="48" height="48">
      <div>
        <p class="mb-0">Forget Me</p>
        <small class="text-white-50">Lewis Capaldi</small>
      </div>
    </div>
     <div class="d-flex align-items-center gap-5">
      <small class="text-white-50 me-3">03:24</small>
      <small class="text-white-50 me-3">2 212 882</small>
      <i class="bi bi-heart me-3"></i>
      <i class="bi bi-three-dots"></i>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
      <span class="me-3 fw-bold text-white-50">04</span>
      <img src="asset/badhabit.jpg" alt="" class="me-3 rounded-3" width="48" height="48">
      <div>
        <p class="mb-0">Bad Habit</p>
        <small class="text-white-50">Steve Lacy</small>
      </div>
    </div>
    <div class="d-flex align-items-center gap-5">
      <small class="text-white-50 me-3">03:32</small>
      <small class="text-white-50 me-3">1 934 291</small>
      <i class="bi bi-heart me-3"></i>
      <i class="bi bi-three-dots"></i>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
      <span class="me-3 fw-bold text-white-50">05</span>
      <img src="asset/dontworry.jpg" alt="" class="me-3 rounded-3" width="48" height="48">
      <div>
        <p class="mb-0">DON'T YOU WORRY</p>
        <small class="text-white-50">Black Eyed Peas, Shakira & David Guetta</small>
      </div>
    </div>
     <div class="d-flex align-items-center gap-5">
      <small class="text-white-50 me-3">03:42</small>
      <small class="text-white-50 me-3">1 556 239</small>
      <i class="bi bi-heart me-3"></i>
      <i class="bi bi-three-dots"></i>
    </div>
  </div>
</main>


  <!-- Bottom Navigation -->
  <footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; background-color: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); z-index: 999;">
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-house-door-fill active-icon"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-search"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-music-note-beamed"></i>
  </button>
  <button class="btn btn-link text-white fs-5 p-0">
    <i class="bi bi-person"></i>
  </button>
</footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>