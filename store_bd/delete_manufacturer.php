<?php
// delete_manufacturer.php – Delete a manufacturer via stored procedure

require_once 'includes/db.php';

$pageTitle  = 'Delete Manufacturer – StoreBD';
$activePage = 'delete';

$message = '';
$msgType = '';

// ── Handle deletion ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manufacturer_id'])) {
    $id = (int) $_POST['manufacturer_id'];

    if ($id <= 0) {
        $message = '⚠️ Please select a valid manufacturer.';
        $msgType = 'error';
    } else {
        // Fetch name before deleting (for confirmation message)
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM manufacturer WHERE id = $id"));

        if (!$row) {
            $message = '⚠️ Manufacturer not found.';
            $msgType = 'error';
        } else {
            $mfrName = htmlspecialchars($row['name']);

            // Call stored procedure (ON DELETE CASCADE handles products)
            $result = mysqli_query($conn, "CALL store_delete_manufacturer($id)");

            if ($result) {
                $message = "✅ Manufacturer <strong>$mfrName</strong> and all its products have been deleted.";
                $msgType = 'success';
            } else {
                $message = '❌ Error: ' . mysqli_error($conn);
                $msgType = 'error';
            }
        }
    }
}

// ── Load manufacturers for dropdown ────────────────────────────
$manufacturers = mysqli_query($conn, 'SELECT id, name, country FROM store_manufacturer_view ORDER BY name');
$has_mfr       = mysqli_num_rows($manufacturers) > 0;

require_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <h1>Delete Manufacturer</h1>
      <p>Remove a manufacturer and all associated products</p>
    </div>
    <i class="bi bi-trash3 header-icon d-none d-md-block"></i>
  </div>
</div>

<div class="container pb-5">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

      <?php if ($message): ?>
        <div class="<?= $msgType === 'success' ? 'alert-success-custom' : 'alert-error-custom' ?> mb-4">
          <?= $message ?>
        </div>
      <?php endif; ?>

      <!-- Warning card -->
      <div class="p-3 mb-4 rounded" style="background:#fff8e5;border:1.5px solid #f0a500;font-size:.875rem;color:#7a5500;">
        <i class="bi bi-exclamation-triangle-fill me-2" style="color:#f0a500"></i>
        <strong>Warning:</strong> Deleting a manufacturer will also delete <em>all products</em> linked to it (CASCADE). This action cannot be undone.
      </div>

      <div class="card">
        <div class="card-header">
          <i class="bi bi-trash3"></i> Select Manufacturer to Delete
        </div>
        <div class="card-body p-4">

          <?php if (!$has_mfr): ?>
            <div class="text-center py-4 text-muted">
              <i class="bi bi-building fs-1 d-block mb-2 opacity-25"></i>
              No manufacturers found. <a href="add_manufacturer.php">Add one first →</a>
            </div>
          <?php else: ?>

            <form method="POST" action=""
                  onsubmit="return confirm('Are you sure you want to delete this manufacturer and ALL its products? This cannot be undone.')">

              <div class="mb-4">
                <label for="manufacturer_id" class="form-label">Manufacturer <span class="text-danger">*</span></label>
                <select id="manufacturer_id" name="manufacturer_id" class="form-select" required>
                  <option value="">— Select Manufacturer —</option>
                  <?php while ($mfr = mysqli_fetch_assoc($manufacturers)): ?>
                    <option value="<?= $mfr['id'] ?>">
                      <?= htmlspecialchars($mfr['name']) ?> — <?= htmlspecialchars($mfr['country']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Procedure note -->
              <div class="mb-4 p-3 rounded" style="background:#fff0f0;border:1px dashed #e74c3c;font-size:.82rem;color:#c0392b;">
                <i class="bi bi-info-circle me-1"></i>
                Deletes via <code>store_delete_manufacturer(id)</code> stored procedure.
                Products are removed via <code>ON DELETE CASCADE</code>.
              </div>

              <div class="d-grid">
                <button type="submit" class="btn-danger-custom">
                  <i class="bi bi-trash3 me-2"></i>Delete Manufacturer
                </button>
              </div>

            </form>

          <?php endif; ?>

        </div>
      </div>

      <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none text-muted small">
          <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
      </div>

    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
