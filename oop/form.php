<?php
$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['checkbox'] = $_POST['checkbox'] ?? '';
    $formData['radio'] = $_POST['radio'] ?? '';

    // Validation
    if (empty($formData['name'])) {
        $errors['name'] = 'Name is required';
    }
    
    if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required';
    }
    
    if (empty($formData['password']) || strlen($formData['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    if (empty($errors)) {
        // Store data in session and open new window
        $_SESSION['formData'] = $formData;
        echo '<script>window.open("display.php", "FormData", "width=600,height=400");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Submission</title>
    <style>
        .error { color: red; font-size: 12px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] { width: 300px; padding: 8px; }
    </style>
</head>
<body>
    <h2>Registration Form</h2>
    <form method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($formData['name'] ?? '') ?>">
            <span class="error"><?= $errors['name'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>">
            <span class="error"><?= $errors['email'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password">
            <span class="error"><?= $errors['password'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <input type="checkbox" name="checkbox" value="yes" <?= ($formData['checkbox'] ?? '') === 'yes' ? 'checked' : '' ?>>
            <label style="display: inline;">I agree to terms</label>
        </div>

        <div class="form-group">
            <label>Choose:</label>
            <input type="radio" name="radio" value="option1" <?= ($formData['radio'] ?? '') === 'option1' ? 'checked' : '' ?>> Option 1
            <input type="radio" name="radio" value="option2" <?= ($formData['radio'] ?? '') === 'option2' ? 'checked' : '' ?>> Option 2
        </div>

        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const errors = {};
        const formData = {
            name: document.querySelector('input[name="name"]').value.trim(),
            email: document.querySelector('input[name="email"]').value.trim(),
            password: document.querySelector('input[name="password"]').value,
            checkbox: document.querySelector('input[name="checkbox"]').checked ? 'yes' : '',
            radio: document.querySelector('input[name="radio"]:checked')?.value || ''
        };
        
        if (!formData.name) errors.name = 'Name is required';
        if (!formData.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            errors.email = 'Valid email is required';
        }
        if (!formData.password || formData.password.length < 6) {
            errors.password = 'Password must be at least 6 characters';
        }
        
        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        
        if (Object.keys(errors).length > 0) {
            Object.keys(errors).forEach(key => {
                document.querySelector(`.error[data-field="${key}"]`).textContent = errors[key];
            });
        } else {
            localStorage.setItem('formData', JSON.stringify(formData));
            window.open('display.html', 'FormData', 'width=600,height=400');
        }
    });
});
</script>
</body>
</html>