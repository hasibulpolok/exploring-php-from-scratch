<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'StoreBD Admin' ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brand:       #1a3c5e;
            --brand-lt:    #2563a8;
            --accent:      #f0a500;
            --surface:     #f4f7fb;
            --card-bg:     #ffffff;
            --border:      #dce4ef;
            --text:        #1c2a3a;
            --muted:       #6b7d93;
            --success-bg:  #eafaf1;
            --success-bdr: #27ae60;
            --error-bg:    #fdf0f0;
            --error-bdr:   #e74c3c;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-brand-text {
            font-family: 'DM Serif Display', serif;
            font-size: 1.4rem;
            color: #fff !important;
            letter-spacing: .5px;
        }
        .navbar {
            background: var(--brand) !important;
            box-shadow: 0 2px 12px rgba(0,0,0,.18);
        }
        .nav-link {
            color: rgba(255,255,255,.82) !important;
            font-weight: 500;
            font-size: .9rem;
            padding: .45rem .85rem !important;
            border-radius: 6px;
            transition: background .18s, color .18s;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,.12);
            color: #fff !important;
        }
        .nav-link i { margin-right: 4px; }

        /* ── Page header ── */
        .page-header {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-lt) 100%);
            color: #fff;
            padding: 2.2rem 0 1.8rem;
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.9rem;
            margin: 0;
        }
        .page-header p {
            margin: .35rem 0 0;
            opacity: .82;
            font-size: .9rem;
        }
        .page-header .header-icon {
            font-size: 2.6rem;
            opacity: .3;
        }

        /* ── Cards ── */
        .card {
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(26,60,94,.06);
        }
        .card-header {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-lt) 100%);
            color: #fff;
            border-radius: 13px 13px 0 0 !important;
            padding: .85rem 1.4rem;
            font-weight: 600;
            font-size: .95rem;
        }
        .card-header i { margin-right: 6px; opacity: .85; }

        /* ── Form controls ── */
        .form-label { font-weight: 500; font-size: .875rem; color: var(--muted); margin-bottom: .3rem; }
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: .9rem;
            padding: .55rem .85rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-lt);
            box-shadow: 0 0 0 3px rgba(37,99,168,.13);
        }

        /* ── Buttons ── */
        .btn-brand {
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: .9rem;
            padding: .6rem 1.6rem;
            transition: background .2s, transform .15s;
        }
        .btn-brand:hover { background: var(--brand-lt); color: #fff; transform: translateY(-1px); }
        .btn-danger-custom {
            background: #c0392b; color: #fff; border: none;
            border-radius: 8px; font-weight: 600; font-size: .9rem;
            padding: .6rem 1.6rem; transition: background .2s, transform .15s;
        }
        .btn-danger-custom:hover { background: #96281b; color: #fff; transform: translateY(-1px); }

        /* ── Alerts ── */
        .alert-success-custom {
            background: var(--success-bg);
            border: 1.5px solid var(--success-bdr);
            color: #1a5c36;
            border-radius: 8px;
            padding: .75rem 1rem;
            font-size: .875rem;
            font-weight: 500;
        }
        .alert-error-custom {
            background: var(--error-bg);
            border: 1.5px solid var(--error-bdr);
            color: #7b1a1a;
            border-radius: 8px;
            padding: .75rem 1rem;
            font-size: .875rem;
            font-weight: 500;
        }

        /* ── Footer ── */
        footer {
            background: var(--brand);
            color: rgba(255,255,255,.65);
            text-align: center;
            padding: 1.1rem;
            font-size: .8rem;
            margin-top: 3rem;
        }
        footer span { color: var(--accent); }
    </style>
</head>
<body>

<!-- ── Navigation ── -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand navbar-brand-text" href="index.php">
      <i class="bi bi-shop-window me-2"></i>StoreBD
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item"><a class="nav-link <?= ($activePage??'')==='manufacturers' ? 'active':'' ?>" href="add_manufacturer.php"><i class="bi bi-building-add"></i>Add Manufacturer</a></li>
        <li class="nav-item"><a class="nav-link <?= ($activePage??'')==='products' ? 'active':'' ?>" href="add_product.php"><i class="bi bi-plus-square"></i>Add Product</a></li>
        <li class="nav-item"><a class="nav-link <?= ($activePage??'')==='delete' ? 'active':'' ?>" href="delete_manufacturer.php"><i class="bi bi-trash3"></i>Delete</a></li>
        <li class="nav-item"><a class="nav-link <?= ($activePage??'')==='view' ? 'active':'' ?>" href="products_view.php"><i class="bi bi-grid-3x3-gap"></i>Products</a></li>
      </ul>
    </div>
  </div>
</nav>
