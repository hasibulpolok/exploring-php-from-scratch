<?php
// ✅ FIX: Correct session check using session_status()
if(session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title ?? "Polok's Book Collection") ?></title>
  <?php include 'style.php'; ?>
  <style>
    .topnav {
      background: var(--burgundy);
      padding: 0 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 64px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 16px rgba(107,39,55,0.25);
    }
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .nav-brand-icon { font-size: 1.5rem; line-height: 1; }
    .nav-brand-text {
      font-family: 'Lora', serif;
      color: #fff;
      font-size: 1.05rem;
      font-style: italic;
    }
    .nav-brand-text span { color: var(--gold); }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 2px;
      list-style: none;
    }
    .nav-links a {
      color: rgba(255,255,255,0.75);
      font-size: 0.86rem;
      font-weight: 500;
      padding: 7px 14px;
      border-radius: 7px;
      text-decoration: none;
      transition: background 0.15s, color 0.15s;
      white-space: nowrap;
    }
    .nav-links a:hover {
      background: rgba(255,255,255,0.12);
      color: #fff;
    }
    .nav-user {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.55);
      padding: 0 14px 0 4px;
      border-right: 1px solid rgba(255,255,255,0.15);
      margin-right: 6px;
    }
    .nav-user strong { color: var(--gold); }
    .nav-search {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .nav-search input {
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 7px;
      padding: 7px 14px;
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 0.84rem;
      outline: none;
      width: 210px;
      transition: background 0.2s, border-color 0.2s;
    }
    .nav-search input::placeholder { color: rgba(255,255,255,0.4); }
    .nav-search input:focus { background: rgba(255,255,255,0.18); border-color: var(--gold); }
    .nav-search button {
      background: var(--gold);
      border: none;
      border-radius: 7px;
      color: #fff;
      padding: 7px 14px;
      font-size: 0.82rem;
      font-weight: 500;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: background 0.2s;
    }
    .nav-search button:hover { background: #b5933e; }
    @media(max-width:768px){ .nav-search { display:none; } .nav-user { display:none; } }
  </style>
</head>
<body>
<nav class="topnav">
  <a href="main.php" class="nav-brand">
    <span class="nav-brand-icon">📚</span>
    <span class="nav-brand-text"><span>Polok</span>'s Books</span>
  </a>

  <ul class="nav-links">
    <?php if(isset($_SESSION['full_name'])): ?>
    <li class="nav-user">Hi, <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong></li>
    <?php endif; ?>
    <li><a href="main.php">Library</a></li>
    <li><a href="add_book.php">+ Add Book</a></li>
    <li><a href="manage_books.php">Manage</a></li>
    <li><a href="logout.php" style="color:rgba(255,255,255,0.45);">Sign out</a></li>
  </ul>

  <form class="nav-search" action="main.php" method="GET">
    <input type="search" name="search" placeholder="Search by title or author…" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit">Search</button>
  </form>
</nav>
