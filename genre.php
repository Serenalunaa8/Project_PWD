<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Streaming - Genre</title>
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

    .custom-placeholder::placeholder {
      color: #c4c4c4;
      opacity: 1;
    }

    .card {
      background: rgba(255, 255, 255, 0.05);
      border: none;
      border-radius: 1rem;
      backdrop-filter: blur(10px);
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: scale(1.03);
      background: rgba(255, 255, 255, 0.1);
    }

    .card-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: #ffffff;
    }

    .card-text {
      color: #cccccc;
      font-size: 0.9rem;
    }

    footer {
      background-color: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
    }

    .genre-card {
      height: 180px;
      background-size: cover;
      background-position: center;
      border-radius: 1rem;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease;
    }

    .genre-card:hover {
      transform: scale(1.03);
      background: rgba(255, 255, 255, 0.1);
    }

    .genre-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.2));
      z-index: 1;
      border-radius: 1rem;
    }

    .genre-card .card-body {
      position: relative;
      z-index: 2;
      padding: 1rem 1rem;
      text-align: left;
      width: 100%;
    }
  </style>
</head>
<body class="d-flex flex-column">

  <!-- Header -->
  <header class="navbar navbar-expand-lg px-3 py-3" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
    <div class="container-fluid">
      <a class="navbar-brand text-light fw-bold" href="#">🎧 StreamBeat</a>
      <form method="POST" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill" style="max-width: 400px;">
        <i class="bi bi-search me-2"></i>
        <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0 custom-placeholder" name="search_query" placeholder="Search music..." style="flex: 1;">
        <div class="vr mx-3"></div>
        <button class="btn btn-dark p-0" type="submit">
          <i class="bi bi-archive-fill"></i>
        </button>
      </form>
    </div>
  </header>

  <!-- Genre Section -->
  <main class="container py-5 flex-grow-1">
    <h1 class="text-center mb-4">Explore Genres</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">

      <!-- Pop -->
      <div class="col">
        <div class="card genre-card text-white d-flex align-items-end" style="background-image: url('asset/pop.jpg');">
          <div class="card-body ps-3">
            <h5 class="card-title">Pop</h5>
            <p class="card-text">Top Pop songs for your mood.</p>
          </div>
        </div>
      </div>

      <!-- Rock -->
      <div class="col">
        <div class="card genre-card text-white d-flex align-items-end" style="background-image: url('asset/rock.jpg');">
          <div class="card-body ps-3">
            <h5 class="card-title">Rock</h5>
            <p class="card-text">Powerful Rock tracks for your energy.</p>
          </div>
        </div>
      </div>

      <!-- Jazz -->
      <div class="col">
        <div class="card genre-card text-white d-flex align-items-end" style="background-image: url('asset/jazz.jpg');">
          <div class="card-body ps-3">
            <h5 class="card-title">Jazz</h5>
            <p class="card-text">Smooth and relaxing Jazz vibes.</p>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Footer Navigation -->
  <footer class="position-fixed bottom-0 start-50 translate-middle-x mb-3 px-4 py-2 rounded-pill d-flex justify-content-between align-items-center shadow-lg" style="width: 90%; z-index: 999;">
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
