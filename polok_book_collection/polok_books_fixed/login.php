<?php
// ✅ FIX: Use session_status() instead of isset($_SESSION)
if(session_status() === PHP_SESSION_NONE) session_start();

// Already logged in? redirect
if(isset($_SESSION['user_name'])){
    header("location:main.php");
    exit();
}

$error = '';
if(isset($_POST['loginbtn'])){
    $input_user = trim($_POST['user_name']);
    $input_pass = trim($_POST['password']);

    // ✅ FIX: Use __DIR__ for reliable path
    $user_file = __DIR__ . "/user.txt";
    if(file_exists($user_file)){
        $lines = file($user_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach($lines as $line){
            $parts = explode("|", trim($line));
            if(count($parts) < 7) continue;
            if(trim($parts[6]) === $input_user && trim($parts[3]) === $input_pass){
                $_SESSION["user_name"] = trim($parts[6]);
                $_SESSION["full_name"] = trim($parts[1]);
                header("location:main.php");
                exit();
            }
        }
    }
    $error = 'Invalid username or password. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Polok's Book Collection</title>
  <?php include 'style.php'; ?>
  <style>
    body { background: linear-gradient(135deg, #f4f1eb 50%, #e8e0d0 100%); }
    .book-icon { font-size: 3rem; margin-bottom: 10px; display:block; text-align:center; }
    .brand-name {
      font-family: 'Lora', serif;
      font-size: 1.15rem;
      color: var(--burgundy);
      text-align: center;
      margin-bottom: 24px;
      font-style: italic;
    }
  </style>
</head>
<body>
<div class="page-center">
  <div class="card form-card">
    <span class="book-icon">📚</span>
    <div class="brand-name">Polok's Book Collection</div>
    <div class="divider"></div>
    <h2 class="page-title">Welcome back</h2>
    <p class="page-sub">Sign in to manage your library</p>

    <?php if($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user_name" placeholder="Your username" required autofocus>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Your password" required>
      </div>
      <button type="submit" name="loginbtn" class="btn-primary" style="width:100%;padding:13px;font-size:1rem;margin-top:6px;">Sign In</button>
    </form>

    <p style="text-align:center;margin-top:22px;font-size:0.88rem;color:var(--muted);">
      Don't have an account? <a href="registration.php">Register here</a>
    </p>
  </div>
</div>
</body>
</html>
