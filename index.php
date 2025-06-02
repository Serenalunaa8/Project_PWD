<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>

.next-button {
  background: linear-gradient(135deg, #4a148c, #303f9f);
  border: none;
  border-radius: 30px;
  padding: 10px;
  width: 100%;
  color: #000;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-bottom: 20px;
}
</style>
<body style="font-family: Helvetica Neue, sans-serif;">
<?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'success'): ?>
    <div class="alert alert-success text-center" role="alert">
        Registration successful! Please log in.
    </div>
<?php endif; ?>
<?php if (isset($_GET['pesan'])): ?>
    <?php if ($_GET['pesan'] === 'error'): ?>
        <div class="alert alert-danger text-center">Please fill in all fields.</div>
    <?php elseif ($_GET['pesan'] === 'invalid'): ?>
        <div class="alert alert-danger text-center">Invalid password. Please try again.</div>
    <?php elseif ($_GET['pesan'] === 'notfound'): ?>
        <div class="alert alert-danger text-center">Username not found. Please register first.</div>
    <?php endif; ?>
<?php endif; ?>
<div class="position-absolute top-50 start-50 translate-middle">
    <div class="card bg-dark text-white" style="width: 28rem; height: 25rem;">
        <div class="card-body">
            <h1 style="text-align: center; font-weight: bold">Log in to<br><span>your account</span></h1>
            <form action="proses_login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="next-button">Log in</button>
                <p class="login-text">Don't have an account? <a href="register.php">Sign up here.</a></p>
            </form>
        </div>
    </div>
</div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>