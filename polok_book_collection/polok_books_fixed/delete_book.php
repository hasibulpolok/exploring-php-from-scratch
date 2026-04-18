<?php
if(session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION["user_name"])){ header("location:login.php"); exit(); }

if(isset($_GET['id'])){
  $delete_id = $_GET['id'];
  // ✅ FIX: Use __DIR__ for reliable path
  $file_path = __DIR__ . "/books_info.txt";
  if(file_exists($file_path)){
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $new_data = [];
    foreach($lines as $line){
      $d = explode("|", trim($line));
      if(trim($d[0]) != $delete_id){
        $new_data[] = trim($line);
      } else {
        // Delete cover image if it exists
        if(!empty($d[5]) && file_exists(__DIR__ . "/" . $d[5])) unlink(__DIR__ . "/" . $d[5]);
      }
    }
    // ✅ FIX: Avoid trailing empty line accumulation
    $content = empty($new_data) ? '' : implode(PHP_EOL, $new_data) . PHP_EOL;
    file_put_contents($file_path, $content);
  }
}
header("Location: manage_books.php");
exit();
?>
