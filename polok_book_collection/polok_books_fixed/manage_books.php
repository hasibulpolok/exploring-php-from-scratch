<?php
if(session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION["user_name"])){ header("location:login.php"); exit(); }
$page_title = "Manage — Polok's Book Collection";
require_once("header.php");
?>
<style>
  body { background: var(--bg); }
  .manage-wrap { max-width: 1050px; margin: 0 auto; padding: 40px 24px 60px; }
  .manage-header {
    display:flex;align-items:flex-end;justify-content:space-between;
    margin-bottom:28px;flex-wrap:wrap;gap:12px;
  }
  .manage-header h1 { font-size:1.8rem;color:var(--ink); }
  .manage-header p { font-size:0.88rem;color:var(--muted);margin-top:4px; }

  .data-table {
    width:100%;border-collapse:collapse;background:#fff;
    border-radius:14px;overflow:hidden;
    border:1px solid var(--border);
    box-shadow:0 2px 12px rgba(0,0,0,0.05);
  }
  .data-table thead { background:var(--burgundy);color:#fff; }
  .data-table thead th {
    padding:13px 16px;
    font-family:'Inter',sans-serif;font-size:0.74rem;
    font-weight:600;text-transform:uppercase;letter-spacing:0.07em;text-align:left;
  }
  .data-table tbody td {
    padding:13px 16px;border-bottom:1px solid var(--border);
    font-size:0.87rem;color:var(--ink);vertical-align:middle;
  }
  .data-table tbody tr:last-child td { border-bottom:none; }
  .data-table tbody tr:hover { background:#faf8f3; }
  .cover-thumb {
    width:44px;height:58px;object-fit:cover;
    border-radius:5px;border:1px solid var(--border);
  }
  .cover-placeholder {
    width:44px;height:58px;
    background:linear-gradient(135deg,var(--burgundy),#8b3a4e);
    border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;
  }
  .desc-cell {
    max-width: 240px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: var(--muted);
    font-size: 0.8rem;
  }
  .action-cell { display:flex;gap:8px;align-items:center; }
  .empty-row td { text-align:center;padding:48px;color:var(--muted); }
</style>

<div class="manage-wrap">
  <div class="manage-header">
    <div>
      <h1>Manage Collection</h1>
      <p>Edit or remove books from your library</p>
    </div>
    <a href="add_book.php" class="btn-primary">+ Add Book</a>
  </div>

  <table class="data-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cover</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Notes</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // ✅ FIX: Use __DIR__ for path, fix empty check logic
      $file_path = __DIR__ . "/books_info.txt";
      if(file_exists($file_path)){
        $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if(empty($lines)){
          echo "<tr class='empty-row'><td colspan='7'>No books yet. <a href='add_book.php'>Add your first book →</a></td></tr>";
        } else {
          foreach($lines as $line){
            $d = explode("|", trim($line));
            while(count($d) < 6) $d[] = '';
            [$id, $title, $author, $year, $desc, $cover] = $d;
            echo "<tr>";
            echo "<td><strong>".htmlspecialchars($id)."</strong></td>";
            if(!empty($cover) && file_exists($cover)){
              echo "<td><img src='".htmlspecialchars($cover)."' class='cover-thumb' alt=''></td>";
            } else {
              echo "<td><div class='cover-placeholder'>📕</div></td>";
            }
            echo "<td>".htmlspecialchars($title)."</td>";
            echo "<td>".htmlspecialchars($author)."</td>";
            echo "<td>".htmlspecialchars($year)."</td>";
            $short_desc = !empty($desc) ? htmlspecialchars(mb_substr($desc, 0, 80)).(mb_strlen($desc)>80?'…':'') : '<span style="color:var(--border);font-style:italic">—</span>';
            echo "<td class='desc-cell' title='".htmlspecialchars($desc)."'>$short_desc</td>";
            echo "<td><div class='action-cell'>
                    <a href='edit_book.php?id=".urlencode($id)."' class='btn-info-sm'>✏ Edit</a>
                    <a href='delete_book.php?id=".urlencode($id)."' class='btn-danger-sm' onclick='return confirm(\"Delete \\\"".htmlspecialchars(addslashes($title))."\\\"? This cannot be undone.\")'>✕ Delete</a>
                  </div></td>";
            echo "</tr>";
          }
        }
      } else {
        echo "<tr class='empty-row'><td colspan='7'>No books found. <a href='add_book.php'>Add your first book →</a></td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
