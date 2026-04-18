<?php
if(session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION["user_name"])){ header("location:login.php"); exit(); }

$msg = '';
if(isset($_POST['add_book'])){
  $id          = trim($_POST['id']);
  $title       = trim($_POST['title']);
  $author      = trim($_POST['author']);
  $year        = trim($_POST['year']);
  $description = str_replace(['|', "\n", "\r"], [' ', ' ', ''], trim($_POST['description']));

  $cover_path = '';
  if(!empty($_FILES['cover_file']['name'])){
    $image_name = $_FILES['cover_file']['name'];
    $image_size = $_FILES['cover_file']['size'];
    $tmp_name   = $_FILES['cover_file']['tmp_name'];
    $type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];
    $max_size = 3*1024*1024;

    if(!in_array($type, $allowed)){
      $msg = '<div class="alert alert-danger">Cover image must be JPG, PNG, or WEBP.</div>';
    } elseif($image_size > $max_size){
      $msg = '<div class="alert alert-danger">Cover image must be under 3MB.</div>';
    } else {
      $cover_path = "covers/" . time() . "_" . basename($image_name);
      if(!move_uploaded_file($tmp_name, $cover_path)){
        $cover_path = '';
        $msg = '<div class="alert alert-danger">Upload failed. Please try again.</div>';
      }
    }
  }

  if(empty($msg)){
    // ✅ FIX: Use __DIR__ for reliable path
    $data = "$id|$title|$author|$year|$description|$cover_path" . PHP_EOL;
    file_put_contents(__DIR__ . "/books_info.txt", $data, FILE_APPEND);
    $msg = '<div class="alert alert-success">Book added to your library! <a href="main.php">View library →</a></div>';
  }
}

$page_title = "Add Book — Polok's Book Collection";
require_once("header.php");
?>
<style>
  body { background: var(--bg); }
  .add-wrap { max-width: 540px; margin: 50px auto; padding: 0 24px 60px; }
  .back-link { font-size:0.86rem;color:var(--muted);display:inline-flex;align-items:center;gap:4px;margin-bottom:22px;text-decoration:none; }
  .back-link:hover { color:var(--burgundy); }
  .file-drop {
    border: 2px dashed var(--border);
    border-radius: 10px; padding: 26px;
    text-align: center; color: var(--muted);
    font-size: 0.88rem; cursor: pointer;
    background: #faf8f3;
    transition: border-color 0.2s, background 0.2s;
  }
  .file-drop:hover { border-color: var(--burgundy); background: #fdf7f8; }
  .file-drop input[type=file] { display:none; }
  #file-chosen { font-size:0.8rem;color:var(--ink);margin-top:8px; }
</style>

<div class="add-wrap">
  <a href="main.php" class="back-link">← Back to Library</a>
  <div class="card">
    <div class="divider"></div>
    <h2 class="page-title">Add New Book</h2>
    <p class="page-sub">Add a book to your collection</p>

    <?= $msg ?>

    <form method="post" enctype="multipart/form-data">
      <div class="two-col">
        <div class="form-group">
          <label>Book ID</label>
          <input type="text" name="id" placeholder="e.g. B001" required>
        </div>
        <div class="form-group">
          <label>Publication Year</label>
          <input type="number" name="year" placeholder="e.g. 2023" min="1000" max="2099" required>
        </div>
      </div>
      <div class="form-group">
        <label>Book Title</label>
        <input type="text" name="title" placeholder="Enter book title" required>
      </div>
      <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" placeholder="Author's full name" required>
      </div>
      <div class="form-group">
        <label>Description / Notes</label>
        <textarea name="description" placeholder="Brief summary, your thoughts, or any notes about this book…" rows="4"></textarea>
      </div>
      <div class="form-group">
        <label>Cover Image (optional)</label>
        <div class="file-drop" onclick="document.getElementById('coverInput').click()">
          <div style="font-size:2rem;margin-bottom:6px;">📗</div>
          Click to upload cover
          <div style="font-size:0.75rem;margin-top:4px;color:var(--muted);">JPG, PNG or WEBP — max 3MB</div>
          <div id="file-chosen">No file selected</div>
          <input type="file" id="coverInput" name="cover_file" accept=".jpg,.jpeg,.png,.webp"
            onchange="document.getElementById('file-chosen').textContent = this.files[0]?.name || 'No file selected'">
        </div>
      </div>
      <button type="submit" name="add_book" class="btn-primary" style="width:100%;padding:13px;font-size:1rem;margin-top:6px;">Add to Library</button>
    </form>
  </div>
</div>

</body>
</html>
