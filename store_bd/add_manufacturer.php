<?php
// add_manufacturer.php – Insert a manufacturer via stored procedure

require_once 'includes/db.php';

$pageTitle  = 'Add Manufacturer – StoreBD';
$activePage = 'manufacturers';

$message = '';
$msgType = '';

// ── Handle form submission ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $country = trim(mysqli_real_escape_string($conn, $_POST['country']));

    if ($name === '' || $country === '') {
        $message = '⚠️ Both Name and Country fields are required.';
        $msgType = 'error';
    } else {
        // Call stored procedure
        $sql    = "CALL store_insert_manufacturer('$name', '$country')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $message = '✅ Manufacturer <strong>' . htmlspecialchars($name) . '</strong> added successfully!';
            $msgType = 'success';
        } else {
            $message = '❌ Error: ' . mysqli_error($conn);
            $msgType = 'error';
        }
    }
}

require_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <h1>Add Manufacturer</h1>
      <p>Register a new manufacturer into the system</p>
    </div>
    <i class="bi bi-building-add header-icon d-none d-md-block"></i>
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

      <div class="card">
        <div class="card-header">
          <i class="bi bi-building-add"></i> Manufacturer Information
        </div>
        <div class="card-body p-4">

          <form method="POST" action="">

            <div class="mb-3">
              <label for="name" class="form-label">Manufacturer Name <span class="text-danger">*</span></label>
              <input type="text" id="name" name="name" class="form-control"
                     placeholder="e.g. Samsung Electronics"
                     value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                     required>
            </div>

            <div class="mb-4">
              <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
              <input type="text" id="country" name="country" class="form-control"
                     placeholder="e.g. South Korea"
                     value="<?= isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '' ?>"
                     required>
            </div>

            <!-- Procedure note -->
            <div class="mb-4 p-3 rounded" style="background:#f0f4ff;border:1px dashed #a0b4d6;font-size:.82rem;color:#2563a8;">
              <i class="bi bi-info-circle me-1"></i>
              Saves via <code>store_insert_manufacturer(name, country)</code> stored procedure.
            </div>

            <div class="d-grid">
              <button type="submit" class="btn-brand">
                <i class="bi bi-save me-2"></i>Save Manufacturer
              </button>
            </div>

          </form>
        </div>
      </div>

      <!-- Quick back link -->
      <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none text-muted small">
          <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
      </div>

    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
