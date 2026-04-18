<?php
session_start();
if(!isset($_SESSION["user_name"])){ header("location:login.php"); exit(); }
$page_title = "Library — Polok's Book Collection";
require_once("header.php");
?>
<style>
  body { background: var(--bg); }
  .library-wrap { max-width: 1100px; margin: 0 auto; padding: 40px 24px 60px; }
  .library-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 36px; flex-wrap: wrap; gap: 16px;
  }
  .library-header h1 { font-size: 2rem; color: var(--ink); }
  .library-header p { font-size: 0.88rem; color: var(--muted); margin-top: 4px; }

  .book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 24px;
  }

  /* Card with flip-on-hover to show description */
  .book-card {
    position: relative;
    height: 320px;
    perspective: 1000px;
    cursor: default;
  }
  .book-inner {
    position: absolute; inset: 0;
    transition: transform 0.5s ease;
    transform-style: preserve-3d;
  }
  .book-card:hover .book-inner { transform: rotateY(180deg); }

  .book-front, .book-back {
    position: absolute; inset: 0;
    backface-visibility: hidden;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    background: #fff;
  }
  .book-back { transform: rotateY(180deg); }

  /* Front */
  .book-cover {
    width: 100%; height: 210px;
    object-fit: cover; display: block;
  }
  .book-cover-placeholder {
    width: 100%; height: 210px;
    background: linear-gradient(135deg, var(--burgundy) 0%, #8b3a4e 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem;
  }
  .book-front-body { padding: 12px 14px 14px; }
  .book-title {
    font-family: 'Lora', serif;
    font-size: 0.95rem; color: var(--ink);
    margin-bottom: 3px; line-height: 1.3;
  }
  .book-author { font-size: 0.76rem; color: var(--muted); }
  .book-year {
    font-size: 0.72rem; color: var(--muted);
    margin-top: 6px; padding-top: 6px;
    border-top: 1px solid var(--border);
  }

  /* Back */
  .book-back {
    display: flex; flex-direction: column;
    background: var(--cream);
    padding: 18px;
  }
  .back-title {
    font-family: 'Lora', serif;
    font-size: 0.95rem; color: var(--ink);
    margin-bottom: 4px;
  }
  .back-author { font-size: 0.75rem; color: var(--burgundy); margin-bottom: 10px; font-weight: 600; }
  .back-desc {
    font-size: 0.8rem; color: var(--muted);
    line-height: 1.55; flex: 1;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 7;
    -webkit-box-orient: vertical;
  }
  .back-year {
    margin-top: 10px; padding-top: 10px;
    border-top: 1px solid var(--border);
    font-size: 0.72rem; color: var(--muted);
  }
  .back-nodesc { font-size:0.8rem;color:var(--border);font-style:italic;margin-top:8px; }

  .empty-state {
    text-align: center; padding: 64px 24px; color: var(--muted);
    grid-column: 1 / -1;
  }
  .empty-state .empty-icon { font-size: 3.5rem; margin-bottom: 16px; display:block; }
  .empty-state h3 { font-size: 1.3rem; margin-bottom: 8px; }
  .empty-state p { font-size: 0.88rem; margin-bottom: 20px; }

  .hint { font-size:0.78rem;color:var(--muted);text-align:right;margin-bottom:12px;font-style:italic; }

  /* Search modal */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(26,26,46,0.5); z-index: 200;
    align-items: center; justify-content: center; padding: 24px;
  }
  .modal-overlay.active { display: flex; }
  .modal-box {
    background: #fff; border-radius: 16px; max-width: 480px;
    width: 100%; overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: popIn 0.2s ease;
  }
  @keyframes popIn { from{transform:scale(0.94);opacity:0} to{transform:scale(1);opacity:1} }
  .modal-head {
    background: var(--burgundy); color: #fff;
    padding: 18px 24px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .modal-head h3 { font-family: 'Lora',serif; font-size: 1.05rem; }
  .modal-close { background:none;border:none;color:rgba(255,255,255,0.6);font-size:1.5rem;cursor:pointer;line-height:1; }
  .modal-close:hover { color:#fff; }
  .modal-body { padding: 20px; max-height: 60vh; overflow-y: auto; }
  .modal-result {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 14px; border: 1px solid var(--border);
    border-radius: 10px; margin-bottom: 12px;
  }
  .modal-result img { width: 54px; height: 72px; object-fit: cover; border-radius: 6px; flex-shrink:0; }
  .modal-result .res-placeholder { width:54px;height:72px;background:linear-gradient(135deg,var(--burgundy),#8b3a4e);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0; }
  .modal-result .res-title { font-family:'Lora',serif;font-size:0.95rem;color:var(--ink); }
  .modal-result .res-author { font-size:0.78rem;color:var(--burgundy);font-weight:600;margin-top:2px; }
  .modal-result .res-year { font-size:0.74rem;color:var(--muted);margin-top:4px; }
  .modal-result .res-desc { font-size:0.78rem;color:var(--muted);margin-top:6px;line-height:1.4; }
  .modal-foot { padding: 14px 20px; border-top: 1px solid var(--border); }
</style>

<div class="library-wrap">
  <div class="library-header">
    <div>
      <h1>My Library</h1>
      <p>Hasibul Polok's personal book collection</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="add_book.php" class="btn-primary">+ Add Book</a>
      <a href="manage_books.php" class="btn-outline">Manage</a>
    </div>
  </div>

  <?php
  // Format: id|title|author|year|description|cover_path
  $file_path = __DIR__ . "/books_info.txt";
  $books = [];
  if(file_exists($file_path)){
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
      $d = explode("|", trim($line));
      if(count($d) < 5) continue;
      // Pad to 6 elements if cover_path missing
      while(count($d) < 6) $d[] = '';
      $books[] = $d;
    }
  }
  ?>

  <?php if(!empty($books)): ?>
    <p class="hint">Hover over a book to read its description</p>
  <?php endif; ?>

  <div class="book-grid">
    <?php if(empty($books)): ?>
      <div class="empty-state">
        <span class="empty-icon">📖</span>
        <h3>Your library is empty</h3>
        <p>Start adding books to build your collection.</p>
        <a href="add_book.php" class="btn-primary">Add First Book</a>
      </div>
    <?php else: ?>
      <?php foreach($books as $b): ?>
        <div class="book-card">
          <div class="book-inner">
            <!-- Front -->
            <div class="book-front">
              <?php if(!empty($b[5]) && file_exists($b[5])): ?>
                <img src="<?= htmlspecialchars($b[5]) ?>" class="book-cover" alt="<?= htmlspecialchars($b[1]) ?>">
              <?php else: ?>
                <div class="book-cover-placeholder">📕</div>
              <?php endif; ?>
              <div class="book-front-body">
                <div class="book-title"><?= htmlspecialchars($b[1]) ?></div>
                <div class="book-author">by <?= htmlspecialchars($b[2]) ?></div>
                <div class="book-year">📅 <?= htmlspecialchars($b[3]) ?></div>
              </div>
            </div>
            <!-- Back -->
            <div class="book-back">
              <div class="back-title"><?= htmlspecialchars($b[1]) ?></div>
              <div class="back-author"><?= htmlspecialchars($b[2]) ?></div>
              <?php if(!empty($b[4])): ?>
                <div class="back-desc"><?= htmlspecialchars($b[4]) ?></div>
              <?php else: ?>
                <div class="back-nodesc">No description added.</div>
              <?php endif; ?>
              <div class="back-year">📅 Published <?= htmlspecialchars($b[3]) ?></div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- Search Modal -->
<?php if(isset($_GET['search']) && !empty(trim($_GET['search']))): ?>
<?php
  $q = trim($_GET['search']);
  $results = [];
  if(file_exists(__DIR__ . "/books_info.txt")){
    $lines = file("books_info.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
      $d = explode("|", $line);
      while(count($d) < 6) $d[] = '';
      if(stripos($d[1],$q)!==false || stripos($d[2],$q)!==false || stripos($d[4],$q)!==false){
        $results[] = $d;
      }
    }
  }
?>
<div class="modal-overlay active" id="searchModal">
  <div class="modal-box">
    <div class="modal-head">
      <h3>Results for "<?= htmlspecialchars($q) ?>"</h3>
      <button class="modal-close" onclick="document.getElementById('searchModal').classList.remove('active')">×</button>
    </div>
    <div class="modal-body">
      <?php if(empty($results)): ?>
        <div class="alert alert-warning">No books found matching "<?= htmlspecialchars($q) ?>".</div>
      <?php else: ?>
        <?php foreach($results as $r): ?>
          <div class="modal-result">
            <?php if(!empty($r[5]) && file_exists($r[5])): ?>
              <img src="<?= htmlspecialchars($r[5]) ?>" alt="">
            <?php else: ?>
              <div class="res-placeholder">📕</div>
            <?php endif; ?>
            <div>
              <div class="res-title"><?= htmlspecialchars($r[1]) ?></div>
              <div class="res-author"><?= htmlspecialchars($r[2]) ?></div>
              <div class="res-year">📅 <?= htmlspecialchars($r[3]) ?></div>
              <?php if(!empty($r[4])): ?>
                <div class="res-desc"><?= htmlspecialchars(mb_substr($r[4], 0, 120)) ?>…</div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="modal-foot">
      <a href="main.php" class="btn-outline" style="width:100%;display:block;text-align:center;">Clear Search</a>
    </div>
  </div>
</div>
<?php endif; ?>

</body>
</html>
