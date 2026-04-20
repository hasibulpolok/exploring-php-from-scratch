<?php
// index.php – Dashboard
require_once 'includes/db.php';

$pageTitle  = 'StoreBD – Dashboard';
$activePage = 'home';

// Quick stats
$mfr_count  = mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM manufacturer'))[0];
$prod_count = mysqli_fetch_row(mysqli_query($conn, 'SELECT COUNT(*) FROM product'))[0];

require_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <h1>Dashboard</h1>
      <p>Welcome to the StoreBD Management System</p>
    </div>
    <i class="bi bi-grid-1x2 header-icon d-none d-md-block"></i>
  </div>
</div>

<div class="container pb-5">

  <!-- Stats row -->
  <div class="row g-4 mb-4">
    <div class="col-sm-6 col-lg-3">
      <div class="card text-center p-3">
        <i class="bi bi-building fs-2 text-primary mb-2"></i>
        <div style="font-size:2rem;font-weight:700;color:var(--brand)"><?= $mfr_count ?></div>
        <div class="text-muted small">Manufacturers</div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card text-center p-3">
        <i class="bi bi-box-seam fs-2 text-warning mb-2"></i>
        <div style="font-size:2rem;font-weight:700;color:var(--brand)"><?= $prod_count ?></div>
        <div class="text-muted small">Products</div>
      </div>
    </div>
  </div>

  <!-- Quick action cards -->
  <div class="row g-4">
    <?php
    $actions = [
      ['icon'=>'building-add','href'=>'add_manufacturer.php','title'=>'Add Manufacturer','desc'=>'Register a new manufacturer with name and country.','color'=>'#1a3c5e'],
      ['icon'=>'plus-square','href'=>'add_product.php','title'=>'Add Product','desc'=>'Add a product linked to an existing manufacturer.','color'=>'#2563a8'],
      ['icon'=>'trash3','href'=>'delete_manufacturer.php','title'=>'Delete Manufacturer','desc'=>'Remove a manufacturer (products deleted automatically).','color'=>'#c0392b'],
      ['icon'=>'grid-3x3-gap','href'=>'products_view.php','title'=>'View Products','desc'=>'Browse all products with full manufacturer details.','color'=>'#27ae60'],
    ];
    foreach ($actions as $a): ?>
    <div class="col-sm-6 col-lg-3">
      <a href="<?= $a['href'] ?>" class="text-decoration-none">
        <div class="card h-100 p-3" style="transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
          <div class="mb-2" style="width:44px;height:44px;border-radius:10px;background:<?= $a['color'] ?>;display:flex;align-items:center;justify-content:center">
            <i class="bi bi-<?= $a['icon'] ?> fs-5 text-white"></i>
          </div>
          <div style="font-weight:600;color:var(--brand);margin-bottom:.25rem"><?= $a['title'] ?></div>
          <div class="text-muted small"><?= $a['desc'] ?></div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<?php require_once 'includes/footer.php'; ?>
