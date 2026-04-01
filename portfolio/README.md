# Md Hasibul Bashar Polok — Portfolio
### LinkedIn-Style PHP Portfolio Application

---

## 📁 File Structure

```
portfolio/
├── index.php                  ← Main portfolio page
├── login.php                  ← Admin login
├── logout.php                 ← Admin logout
├── config.php                 ← Configuration (DB, admin creds, settings)
│
├── includes/
│   ├── data.php               ← All DB query functions
│   └── contact_handler.php    ← Contact form POST handler (returns JSON)
│
├── admin/
│   └── index.php              ← Admin dashboard (profile/skills/projects/messages)
│
├── database/
│   └── setup.sql              ← Run once to create DB + seed data
│
└── assets/
    ├── css/
    │   ├── style.css          ← Main styles (LinkedIn-inspired)
    │   └── admin.css          ← Admin panel styles
    ├── js/
    │   └── main.js            ← Loader, dark mode, animations, contact form
    └── images/
        ├── avatar.svg         ← Profile picture placeholder (replace with real photo)
        └── resume.pdf         ← Place your CV here (for the Download button)
```

---

## 🚀 Setup Instructions

### 1. Place files
Copy the `portfolio/` folder into your web root:
- **XAMPP**: `C:/xampp/htdocs/portfolio`
- **Laragon**: `C:/laragon/www/portfolio`

### 2. Create the database
Open **phpMyAdmin** (http://localhost/phpmyadmin) and run:
```sql
SOURCE /path/to/portfolio/database/setup.sql;
```
Or import the `database/setup.sql` file via the Import tab.

### 3. Configure `config.php`
Edit the top of `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', '');           // Your MySQL password
define('SITE_URL', 'http://localhost/portfolio');
define('WHATSAPP_NUMBER', '8801XXXXXXXXX'); // Your real WhatsApp number
```

### 4. Change the Admin Password
Open a PHP shell (or create a temp file) and run:
```php
echo password_hash('YourNewPassword', PASSWORD_BCRYPT);
```
Then update `ADMIN_PASSWORD_HASH` in `config.php` with the output.

### 5. Add your profile photo
Replace `assets/images/avatar.svg` with your photo (JPG/PNG recommended).
Update the `<img>` `src` in `index.php` if using a different filename.

### 6. Add your resume
Place your PDF CV at `assets/images/resume.pdf`.

### 7. Open in browser
- **Portfolio**: http://localhost/portfolio/
- **Admin Login**: http://localhost/portfolio/login.php
  - Default username: `admin`
  - Default password: `admin123` ← **Change this immediately!**

---

## 🔐 Security Notes

- Change the admin password before deploying
- Set `secure => true` in session config when on HTTPS
- The contact form uses CSRF tokens + server-side validation
- All DB queries use PDO prepared statements (no SQL injection)
- All output uses `htmlspecialchars()` (no XSS)

---

## ✨ Features

| Feature | Status |
|---------|--------|
| LinkedIn-style profile card | ✅ |
| Open to Work badge | ✅ |
| Skills with animated progress bars | ✅ |
| Experience timeline | ✅ |
| Project cards | ✅ |
| Contact form (PHP + AJAX) | ✅ |
| WhatsApp click-to-chat | ✅ |
| Social media links | ✅ |
| Admin panel (CRUD) | ✅ |
| Dark mode toggle | ✅ |
| Loading animation | ✅ |
| Scroll-to-top button | ✅ |
| Counter animations | ✅ |
| Fully responsive (mobile-first) | ✅ |
| CSRF protection | ✅ |
| Session-based auth | ✅ |
| PDO prepared statements | ✅ |
| XSS protection | ✅ |

---

## 📝 Customization

- **Colors**: Edit CSS variables at the top of `assets/css/style.css`
- **Fonts**: Change the Google Fonts import in `index.php` and update `--font-body`
- **Profile data**: Use the Admin Panel at `/login.php` to edit everything live

---

Built with ❤ — PHP, MySQL, vanilla JS, CSS
