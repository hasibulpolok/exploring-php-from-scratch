<?php
if(session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION["user_name"])){ header("location:login.php"); exit(); }

$id = $_GET['id'] ?? '';
// ✅ FIX: Use __DIR__ for reliable path
$file_path = __DIR__ . "/books_info.txt";
$book = [];
$lines = file_exists($file_path) ? file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

foreach($lines as $line){
  $d = explode("|", trim($line));
  while(count($d) < 6) $d[] = '';
  if(trim($d[0]) == $id){ $book = $d; break; }
}

if(isset($_POST['update_book'])){
  $new_id    = trim($_POST['id']);
  $new_title  = trim($_POST['title']);
  $new_author = trim($_POST['author']);
  $new_year   = trim($_POST['year']);
  $new_desc   = str_replace(['|', "\n", "\r"], [' ', ' ', ''], trim($_POST['description']));
  $old_cover  = $_POST['old_cover'];
  $new_cover  = $old_cover;

  if(!empty($_FILES['cover_file']['name'])){
    $ext = strtolower(pathinfo($_FILES['cover_file']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];
    if(in_array($ext, $allowed)){
      $new_cover = "covers/" . time() . "_" . basename($_FILES['cover_file']['name']);
      if(move_uploaded_file($_FILES['cover_file']['tmp_name'], __DIR__ . "/" . $new_cover)){
        // Delete old cover
        if(!empty($old_cover) && file_exists(__DIR__ . "/" . $old_cover)) unlink(__DIR__ . "/" . $old_cover);
      } else {
        $new_cover = $old_cover; // fallback to old cover on failure
      }
    }
  }

  $updated = [];
  foreach($lines as $line){
    $d = explode("|", trim($line));
    if(trim($d[0]) == $id){
      $updated[] = "$new_id|$new_title|$new_author|$new_year|$new_desc|$new_cover";
    } else {
      $updated[] = trim($line);
    }
  }
  // ✅ FIX: Clean write without trailing empty lines
  $content = empty($updated) ? '' : implode(PHP_EOL, $updated) . PHP_EOL;
  file_put_contents($file_path, $content);
  header("Location: manage_books.php");
  exit();
}

$page_title = "Edit Book — Polok's Book Collection";
require_once("header.php");
?>
<style>
  body { background: var(--bg); }
  .edit-wrap { max-width: 540px; margin: 50px auto; padding: 0 24px 60px; }
  .back-link { font-size:0.86rem;color:var(--muted);display:inline-flex;align-items:center;gap:4px;margin-bottom:22px;text-decoration:none; }
  .back-link:hover { color:var(--burgundy); }
  .current-cover {
    display:flex;align-items:center;gap:14px;
    background:#faf8f3;border:1px solid var(--border);
    border-radius:10px;padding:14px;margin-bottom:10px;
  }
  .current-cover img { width:54px;height:72px;object-fit:cover;border-radius:6px; }
  .current-cover span { font-size:0.82rem;color:var(--muted); }
</style>

<div class="edit-wrap">
  <a href="manage_books.php" class="back-link">← Back to Manage</a>

  <?php if(empty($book)): ?>
    <div class="alert alert-danger">Book not found.</div>
  <?php else: ?>
  <div class="card">
    <div class="divider"></div>
    <h2 class="page-title">Edit Book</h2>
    <p class="page-sub">Updating "<?= htmlspecialchars($book[1]) ?>"</p>

    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="old_cover" value="<?= htmlspecialchars($book[5] ?? '') ?>">

      <div class="two-col">
        <div class="form-group">
          <label>Book ID</label>
          <input type="text" name="id" value="<?= htmlspecialchars($book[0]) ?>" required>
        </div>
        <div class="form-group">
          <label>Publication Year</label>
          <input type="number" name="year" value="<?= htmlspecialchars($book[3]) ?>" min="1000" max="2099" required>
        </div>
      </div>
      <div class="form-group">
        <label>Book Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book[1]) ?>" required>
      </div>
      <div class="form-group">
        <label>Author</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book[2]) ?>" required>
      </div>
      <div class="form-group">
        <label>Description / Notes</label>
        <textarea name="description" rows="4" placeholder="Brief summary, your thoughts, or any notes…"><?= htmlspecialchars($book[4] ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label>Cover Image</label>
        <?php if(!empty($book[5]) && file_exists(__DIR__ . "/" . $book[5])): ?>
        <div class="current-cover">
          <img src="<?= htmlspecialchars($book[5]) ?>" alt="Cover">
          <span>Leave empty to keep current cover</span>
        </div>
        <?php else: ?>
          <p style="font-size:0.82rem;color:var(--muted);margin-bottom:8px;">No cover image set. Upload one below.</p>
        <?php endif; ?>
        <label>Replace Cover (optional)</label>
        <input type="file" name="cover_file" accept=".jpg,.jpeg,.png,.webp">
      </div>

      <div style="display:flex;gap:12px;margin-top:8px;">
        <button type="submit" name="update_book" class="btn-primary" style="flex:1;padding:12px;font-size:1rem;">Save Changes</button>
        <a href="manage_books.php" class="btn-outline" style="flex:1;padding:12px;text-align:center;">Cancel</a>
      </div>
    </form>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
