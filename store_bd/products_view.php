<?php
// products_view.php – Public product listing using store_product_view (DB VIEW)

require_once 'includes/db.php';

$pageTitle  = 'Browse Products – StoreBD';
$activePage = 'view';

// ── Optional search filter ──────────────────────────────────────
$search = trim(mysqli_real_escape_string($conn, $_GET['q'] ?? ''));

if ($search !== '') {
    $sql = "SELECT * FROM store_product_view
            WHERE product_name LIKE '%$search%'
               OR model        LIKE '%$search%'
               OR manufacturer_name LIKE '%$search%'
               OR manufacturer_country LIKE '%$search%'
            ORDER BY id DESC";
} else {
    // Call stored procedure (also reads from store_product_view)
    $sql = 'CALL store_get_all_products()';
}

$result   = mysqli_query($conn, $sql);
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

require_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <h1>Browse Products</h1>
      <p>All products with full manufacturer details — powered by <code style="background:rgba(255,255,255,.15);padding:1px 6px;border-radius:4px">store_product_view</code></p>
    </div>
    <i class="bi bi-grid-3x3-gap header-icon d-none d-md-block"></i>
  </div>
</div>

<div class="container pb-5">

  <!-- Search bar -->
  <form method="GET" class="mb-4">
    <div class="input-group" style="max-width:480px">
      <input type="text" name="q" class="form-control"
             placeholder="Search by product, model, manufacturer…"
             value="<?= htmlspecialchars($search) ?>">
      <button type="submit" class="btn-brand" style="border-radius:0 8px 8px 0;padding:.55rem 1.2rem">
        <i class="bi bi-search"></i>
      </button>
      <?php if ($search): ?>
        <a href="products_view.php" class="btn btn-outline-secondary ms-1" style="border-radius:8px">
          <i class="bi bi-x"></i> Clear
        </a>
      <?php endif; ?>
    </div>
    <?php if ($search): ?>
      <div class="mt-2 text-muted small">
        Showing <?= count($products) ?> result(s) for "<strong><?= htmlspecialchars($search) ?></strong>"
      </div>
    <?php endif; ?>
  </form>

  <?php if (empty($products)): ?>
    <!-- Empty state -->
    <div class="card p-5 text-center">
      <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-25"></i>
      <h5 class="text-muted">No products found</h5>
      <p class="text-muted small mb-3">
        <?= $search ? 'Try a different search term.' : 'Add some products to get started.' ?>
      </p>
      <a href="add_product.php" class="btn-brand d-inline-block" style="width:fit-content;margin:0 auto">
        <i class="bi bi-plus-square me-2"></i>Add First Product
      </a>
    </div>

  <?php else: ?>

    <!-- Product grid -->
    <div class="row g-4">
      <?php foreach ($products as $p): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="card h-100" style="transition:transform .2s,box-shadow .2s"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(26,60,94,.12)'"
             onmouseout="this.style.transform='';this.style.boxShadow=''">

          <!-- Coloured top strip -->
          <div style="height:5px;background:linear-gradient(90deg,var(--brand),var(--brand-lt));border-radius:13px 13px 0 0"></div>

          <div class="card-body p-4">
            <!-- Product name & model -->
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="mb-0" style="font-weight:700;color:var(--brand);line-height:1.3;font-size:1rem">
                <?= htmlspecialchars($p['product_name']) ?>
              </h5>
              <span class="badge ms-2 text-nowrap" style="background:var(--brand);font-size:.72rem;border-radius:6px;padding:4px 8px">
                <?= htmlspecialchars($p['model']) ?>
              </span>
            </div>

            <!-- Description -->
            <?php if (!empty($p['description'])): ?>
              <p class="text-muted small mb-3" style="line-height:1.5;min-height:2.5rem">
                <?= htmlspecialchars(mb_strimwidth($p['description'], 0, 90, '…')) ?>
              </p>
            <?php else: ?>
              <p class="text-muted small mb-3 fst-italic">No description available.</p>
            <?php endif; ?>

            <!-- Price -->
            <div class="mb-3" style="font-size:1.35rem;font-weight:700;color:var(--accent)">
              ৳ <?= number_format($p['price'], 2) ?>
            </div>

            <hr style="border-color:var(--border);margin:.75rem 0">

            <!-- Manufacturer info -->
            <div class="d-flex align-items-center gap-2">
              <div style="width:34px;height:34px;border-radius:8px;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="bi bi-building text-muted" style="font-size:.85rem"></i>
              </div>
              <div>
                <div style="font-weight:600;font-size:.875rem;color:var(--text)">
                  <?= htmlspecialchars($p['manufacturer_name']) ?>
                </div>
                <div class="text-muted" style="font-size:.78rem">
                  <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($p['manufacturer_country']) ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Total count -->
    <div class="text-muted small text-end mt-3">
      Showing <?= count($products) ?> product(s) &mdash; data from <code>store_product_view</code>
    </div>

  <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>
