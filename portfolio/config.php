<?php
/**
 * config.php — Central configuration for the portfolio application.
 * Update DB credentials, admin password, and site settings here.
 */

// ─── Database ───────────────────────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ─── Admin Credentials ───────────────────────────────────────────────────────
// Change this password before deploying!
define('ADMIN_USERNAME', 'admin');
// bcrypt hash of "admin123" — regenerate with: password_hash('yourpassword', PASSWORD_BCRYPT)
define('ADMIN_PASSWORD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

// ─── Site Settings ───────────────────────────────────────────────────────────
define('SITE_NAME', 'Md Hasibul Bashar Polok');
define('SITE_URL', 'http://localhost/portfolio');
define('CONTACT_EMAIL', 'hasibulpolok.bdn@gmail.com');
define('WHATSAPP_NUMBER', '8801XXXXXXXXX'); // replace with real number

// ─── Session & Security ──────────────────────────────────────────────────────
define('SESSION_LIFETIME', 3600); // 1 hour
define('CSRF_TOKEN_KEY', 'csrf_token');

// ─── Start session if not already started ────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'secure'   => false,   // set true on HTTPS
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

// ─── PDO Connection ──────────────────────────────────────────────────────────
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // In production, log error instead of echoing
            error_log('DB Connection failed: ' . $e->getMessage());
            die(json_encode(['error' => 'Database connection failed.']));
        }
    }
    return $pdo;
}

// ─── CSRF Helpers ────────────────────────────────────────────────────────────
function generateCsrfToken(): string {
    if (empty($_SESSION[CSRF_TOKEN_KEY])) {
        $_SESSION[CSRF_TOKEN_KEY] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_KEY];
}

function verifyCsrfToken(string $token): bool {
    return isset($_SESSION[CSRF_TOKEN_KEY]) && hash_equals($_SESSION[CSRF_TOKEN_KEY], $token);
}

// ─── Sanitization Helper ─────────────────────────────────────────────────────
function clean(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// ─── Auth Check ──────────────────────────────────────────────────────────────
function isAdminLoggedIn(): bool {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin(): void {
    if (!isAdminLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
}
