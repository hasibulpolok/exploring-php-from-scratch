<?php
/**
 * login.php — Admin login page.
 */
require_once __DIR__ . '/config.php';

// Redirect if already logged in
if (isAdminLoggedIn()) {
    header('Location: ' . SITE_URL . '/admin/index.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
        $error = 'Invalid security token. Please refresh.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user']      = $username;
            $_SESSION['login_time']      = time();
            unset($_SESSION[CSRF_TOKEN_KEY]); // rotate token after login

            header('Location: ' . SITE_URL . '/admin/index.php');
            exit;
        } else {
            // Slow down brute force
            sleep(1);
            $error = 'Invalid username or password.';
        }
    }
}

$csrf = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-avatar"><i class="fas fa-user-shield"></i></div>
            <h1>Admin Portal</h1>
            <p><?= clean(SITE_NAME) ?></p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= clean($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="login-form" novalidate>
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">

            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" placeholder="admin"
                       autocomplete="username" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="input-eye">
                    <input type="password" id="password" name="password" placeholder="••••••••"
                           autocomplete="current-password" required>
                    <button type="button" class="eye-toggle" onclick="togglePwd()">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="login-back">
            <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Portfolio</a>
        </div>
    </div>
</div>

<script>
function togglePwd() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        pwd.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
</body>
</html>
