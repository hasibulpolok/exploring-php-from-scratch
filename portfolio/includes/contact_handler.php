<?php
/**
 * includes/contact_handler.php
 * Processes the public contact form submission.
 * Returns JSON so the frontend JS can display feedback without page reload.
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/data.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ─── CSRF Verification ───────────────────────────────────────────────────────
$csrfToken = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid security token. Please refresh the page.']);
    exit;
}

// ─── Collect & Sanitize Input ────────────────────────────────────────────────
$name    = clean($_POST['name']    ?? '');
$email   = clean($_POST['email']   ?? '');
$subject = clean($_POST['subject'] ?? '');
$message = clean($_POST['message'] ?? '');

// ─── Validation ──────────────────────────────────────────────────────────────
$errors = [];

if (mb_strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (mb_strlen($subject) < 3) {
    $errors[] = 'Subject must be at least 3 characters.';
}
if (mb_strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ─── Save to DB ──────────────────────────────────────────────────────────────
try {
    $saved = saveContactMessage($name, $email, $subject, $message);

    if ($saved) {
        // Optionally send email notification (requires mail() configured or PHPMailer)
        // mail(CONTACT_EMAIL, "New message: $subject", "From: $name <$email>\n\n$message");

        // Regenerate CSRF token after successful submission
        unset($_SESSION[CSRF_TOKEN_KEY]);

        echo json_encode(['success' => true, 'message' => 'Your message has been sent! I\'ll get back to you shortly.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save message. Please try again.']);
    }
} catch (Exception $e) {
    error_log('Contact handler error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
