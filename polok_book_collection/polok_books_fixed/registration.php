<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — Polok's Book Collection</title>
  <?php include 'style.php'; ?>
  <style>
    body { background: linear-gradient(135deg, #f4f1eb 50%, #e8e0d0 100%); }
    .form-card { max-width: 540px; }
  </style>
</head>
<body>
<div class="page-center" style="padding: 40px 24px;">
  <div class="card form-card">
    <div style="text-align:center;margin-bottom:4px;">
      <span style="font-size:2.2rem;">📚</span>
      <div style="font-family:'Lora',serif;font-size:1rem;color:var(--burgundy);font-style:italic;margin-top:6px;margin-bottom:20px;">Polok's Book Collection</div>
    </div>
    <div class="divider"></div>
    <h2 class="page-title">Create account</h2>
    <p class="page-sub">Join to start curating your personal library</p>

    <?php
    $msg = '';
    if(isset($_POST['register'])){
        $id       = trim($_POST['id']);
        $name     = trim($_POST['name']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm  = trim($_POST['confirm_password']);
        $address  = trim($_POST['address']);
        $contact  = trim($_POST['contact']);
        $user_name= trim($_POST['user_name']);

        $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $pass_pattern  = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

        if(empty($id) || empty($name) || empty($user_name)){
            $msg = '<div class="alert alert-danger">Please fill all required fields.</div>';
        } elseif(!preg_match($email_pattern, $email)){
            $msg = '<div class="alert alert-danger">Please enter a valid email address.</div>';
        } elseif(!preg_match($pass_pattern, $password)){
            $msg = '<div class="alert alert-danger">Password must be at least 8 characters with letters and numbers.</div>';
        } elseif($password !== $confirm){
            $msg = '<div class="alert alert-danger">Passwords do not match.</div>';
        } else {
            // ✅ FIX: Duplicate username/ID check
            $user_file = __DIR__ . "/user.txt";
            $duplicate = false;
            if(file_exists($user_file)){
                $existing = file($user_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach($existing as $line){
                    $parts = explode("|", trim($line));
                    if(count($parts) < 7) continue;
                    if(trim($parts[0]) === $id){
                        $msg = '<div class="alert alert-danger">User ID already exists. Please choose another.</div>';
                        $duplicate = true; break;
                    }
                    if(trim($parts[6]) === $user_name){
                        $msg = '<div class="alert alert-danger">Username already taken. Please choose another.</div>';
                        $duplicate = true; break;
                    }
                    if(trim($parts[2]) === $email){
                        $msg = '<div class="alert alert-danger">Email already registered.</div>';
                        $duplicate = true; break;
                    }
                }
            }
            if(!$duplicate){
                // ✅ FIX: Use __DIR__ for reliable path
                $file = fopen($user_file, "a");
                $data = $id."|".$name."|".$email."|".$password."|".$address."|".$contact."|".$user_name.PHP_EOL;
                fwrite($file, $data);
                fclose($file);
                $msg = '<div class="alert alert-success">Registration successful! Redirecting to login…</div>';
                echo '<meta http-equiv="refresh" content="2;url=login.php">';
            }
        }
    }
    echo $msg;
    ?>

    <form method="post">
      <div class="two-col">
        <div class="form-group">
          <label>User ID</label>
          <input type="text" name="id" placeholder="e.g. 2025001" required>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="user_name" placeholder="Choose a username" required>
        </div>
      </div>
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Your full name" required>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required>
      </div>
      <div class="two-col">
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Min 8 chars" required>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Repeat password" required>
        </div>
      </div>
      <div class="two-col">
        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" placeholder="Your address" required>
        </div>
        <div class="form-group">
          <label>Contact Number</label>
          <input type="text" name="contact" placeholder="01XXXXXXXXX" required>
        </div>
      </div>
      <button type="submit" name="register" class="btn-primary" style="width:100%;padding:13px;font-size:1rem;margin-top:4px;">Create Account</button>
    </form>

    <p style="text-align:center;margin-top:20px;font-size:0.88rem;color:var(--muted);">
      Already have an account? <a href="login.php">Sign in</a>
    </p>
  </div>
</div>
</body>
</html>
