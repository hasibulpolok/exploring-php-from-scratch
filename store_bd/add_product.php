<?php
// add_product.php – Insert a product via stored procedure

require_once 'includes/db.php';

$pageTitle  = 'Add Product – StoreBD';
$activePage = 'products';

$message = '';
$msgType = '';

// ── Handle form submission ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manufacturer_id = (int) $_POST['manufacturer_id'];
    $product_name    = trim(mysqli_real_escape_string($conn, $_POST['product_name']));
    $model           = trim(mysqli_real_escape_string($conn, $_POST['model']));
    $price           = floatval($_POST['price']);
    $description     = trim(mysqli_real_escape_string($conn, $_POST['description']));

    if ($manufacturer_id <= 0 || $product_name === '' || $model === '' || $price <= 0) {
        $message = '⚠️ Please fill in all required fields correctly.';
        $msgType = 'error';
    } else {
        // Call stored procedure
        $sql = "CALL store_insert_product($manufacturer_id, '$product_name', '$model', $price, '$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $message = '✅ Product <strong>' . htmlspecialchars($product_name) . '</strong> added successfully!';
            $msgType = 'success';
        } else {
            $message = '❌ Error: ' . mysqli_error($conn);
            $msgType = 'error';
        }
    }
}

// ── Load manufacturers for dropdown (from view) ─────────────────
$manufacturers = mysqli_query($conn, 'SELECT id, name, country FROM store_manufacturer_view ORDER BY name');

require_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <h1>Add Product</h1>
      <p>Register a new product linked to a manufacturer</p>
    </div>
    <i class="bi bi-plus-square header-icon d-none d-md-block"></i>
  </div>
</div>

<div class="container pb-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">

      <?php if ($message): ?>
        <div class="<?= $msgType === 'success' ? 'alert-success-custom' : 'alert-error-custom' ?> mb-4">
          <?= $message ?>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header">
          <i class="bi bi-box-seam"></i> Product Details
        </div>
        <div class="card-body p-4">

          <form method="POST" action="">

            <!-- Manufacturer dropdown -->
            <div class="mb-3">
              <label for="manufacturer_id" class="form-label">Manufacturer <span class="text-danger">*</span></label>
              <select id="manufacturer_id" name="manufacturer_id" class="form-select" required>
                <option value="">— Select Manufacturer —</option>
                <?php while ($mfr = mysqli_fetch_assoc($manufacturers)): ?>
                  <option value="<?= $mfr['id'] ?>"
                    <?= (isset($_POST['manufacturer_id']) && $_POST['manufacturer_id'] == $mfr['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mfr['name']) ?> (<?= htmlspecialchars($mfr['country']) ?>)
                  </option>
                <?php endwhile; ?>
              </select>
              <div class="form-text">Don't see your manufacturer? <a href="add_manufacturer.php">Add one first →</a></div>
            </div>

            <div class="row g-3">
              <div class="col-sm-7">
                <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" id="product_name" name="product_name" class="form-control"
                       placeholder="e.g. Galaxy S24 Ultra"
                       value="<?= isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '' ?>"
                       required>
              </div>
              <div class="col-sm-5">
                <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                <input type="text" id="model" name="model" class="form-control"
                       placeholder="e.g. SM-S9280"
                       value="<?= isset($_POST['model']) ? htmlspecialchars($_POST['model']) : '' ?>"
                       required>
              </div>
            </div>

            <div class="mt-3 mb-3">
              <label for="price" class="form-label">Price (৳ BDT) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text" style="background:var(--brand);color:#fff;border:none;border-radius:8px 0 0 8px">৳</span>
                <input type="number" id="price" name="price" class="form-control" style="border-radius:0 8px 8px 0"
                       placeholder="0.00" step="0.01" min="0"
                       value="<?= isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '' ?>"
                       required>
              </div>
            </div>

            <div class="mb-4">
              <label for="description" class="form-label">Description</label>
              <textarea id="description" name="description" class="form-control" rows="3"
                        placeholder="Brief description of the product..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
            </div>

            <!-- Procedure note -->
            <div class="mb-4 p-3 rounded" style="background:#f0f4ff;border:1px dashed #a0b4d6;font-size:.82rem;color:#2563a8;">
              <i class="bi bi-info-circle me-1"></i>
              Saves via <code>store_insert_product(manufacturer_id, product_name, model, price, description)</code> stored procedure.
            </div>

            <div class="d-grid">
              <button type="submit" class="btn-brand">
                <i class="bi bi-save me-2"></i>Save Product
              </button>
            </div>

          </form>
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
