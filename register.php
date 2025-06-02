<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'error'): ?>
    <div class="alert alert-danger text-center" role="alert">
        Please fill in all fields.
    </div>
<?php elseif (isset($_GET['pesan']) && $_GET['pesan'] === 'failed'): ?>
    <div class="alert alert-danger text-center" role="alert">
        Registration failed. Please try again.
    </div>
<?php endif; ?>
<div class="position-absolute top-50 start-50 translate-middle">
    <div class="card bg-dark text-white" style="width: 28rem; height: 29rem;">
        <div class="card-body">
            <h1 style="text-align: center; font-weight: bold">Sign up to<br><span>start listening</span></h1>
            <form action="cekregist.php" method="POST">
    <div class="mb-3">

        <label>Username</label>
        <input type="text" class="form-control" id="username" name="username" required>

        <label for="exampleFormControlInput1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email" required>
        
        <label for="password" class="pass">Password</label>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="password" required>
        
    </div>
    <button type="submit" class="next-button">Sign up</button>
    <p class="login-text">Already have an account? <a href="index.php">Log in here.</a></p>
</form>
        </div>
    </div>
</div>
    
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>