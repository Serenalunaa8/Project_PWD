<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Music Streaming</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Rowdies:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #121212;
      color: white;
    }

    .navbar-brand {
      font-family: 'Rowdies', sans-serif;
      font-weight: 700;
      font-size: 2.5rem;
    }

    .custom-placeholder::placeholder {
      color: #ccc;
      opacity: 0.8;
    }

    .form-control:focus {
      box-shadow: none;
      outline: none;
    }
  </style>
</head>
<body class="d-flex flex-column">

  <!-- Header -->
  <header class="navbar navbar-expand-lg p-4 w-100 fixed-top" style="background: linear-gradient(135deg, #4a148c, #303f9f);">
    <div class="container-fluid px-1">
      <a class="navbar-brand text-light" href="#">🎧 My Melodist</a>
      <form method="POST" action="search.php" class="d-flex align-items-center bg-dark text-white px-3 py-2 rounded-pill ms-auto" style="max-width: 400px;">
        <i class="bi bi-search me-2"></i>
        <input type="text" class="form-control bg-dark text-white border-0 shadow-none px-0 custom-placeholder" name="search_query" placeholder="What do you want to play?" style="flex: 1;">
        <div class="vr mx-3"></div>
        <button class="btn btn-dark p-0" type="submit">
          <i class="bi bi-archive-fill"></i>
        </button>
      </form>
    </div>
  </header>
  <br><br>

</body>
</html>
