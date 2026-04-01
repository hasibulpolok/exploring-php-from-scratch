<?php
// Prevent multiple session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL (adjust if needed)
define('BASE_URL', 'http://localhost/php/new-profile-linkedin/portfolio/');

// Generate CSRF Token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        try {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (Exception $e) {
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        }
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF Token
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Clean output (XSS protection)
function clean($data) {
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

// Admin login check
function isAdminLoggedIn() {
    return !empty($_SESSION['admin_logged_in']);
}