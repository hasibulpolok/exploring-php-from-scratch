<?php /* Shared styles for Hasibul Polok's Book Collection */ ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap');

  :root {
    --bg: #f4f1eb;
    --ink: #1a1a2e;
    --burgundy: #6b2737;
    --burgundy-light: #8b3a4e;
    --gold: #c9a84c;
    --cream: #faf8f3;
    --muted: #7a7060;
    --border: #e0d9cc;
    --card-bg: #ffffff;
    --success: #2d6a4f;
    --danger: #9b2335;
    --info: #1d4e89;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--ink);
    min-height: 100vh;
  }

  h1, h2, h3, h4 {
    font-family: 'Lora', serif;
    letter-spacing: -0.01em;
  }

  .card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    padding: 40px;
  }

  .btn-primary {
    background: var(--burgundy);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 11px 24px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 0.92rem;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    display: inline-block;
    text-decoration: none;
  }
  .btn-primary:hover { background: var(--burgundy-light); transform: translateY(-1px); color: #fff; }

  .btn-outline {
    background: transparent;
    color: var(--ink);
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 10px 22px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 0.88rem;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s;
    display: inline-block;
    text-decoration: none;
  }
  .btn-outline:hover { border-color: var(--burgundy); color: var(--burgundy); }

  .btn-danger-sm {
    background: #fdf0f0;
    color: var(--danger);
    border: 1px solid #f0c0c0;
    border-radius: 6px;
    padding: 5px 14px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
  }
  .btn-danger-sm:hover { background: var(--danger); color: #fff; }

  .btn-info-sm {
    background: #eef3fb;
    color: var(--info);
    border: 1px solid #b8ccea;
    border-radius: 6px;
    padding: 5px 14px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s;
  }
  .btn-info-sm:hover { background: var(--info); color: #fff; }

  .form-group { margin-bottom: 20px; }
  .form-group label {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 7px;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.92rem;
    color: var(--ink);
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: var(--burgundy);
    box-shadow: 0 0 0 3px rgba(107,39,55,0.10);
  }
  .form-group textarea { resize: vertical; min-height: 80px; }

  .alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.88rem;
    margin-bottom: 16px;
  }
  .alert-success { background: #eaf5ef; color: #1e5c38; border: 1px solid #a8d8bc; }
  .alert-danger  { background: #fdecea; color: #7b1e1e; border: 1px solid #f0aaaa; }
  .alert-warning { background: #fef9e7; color: #7a6000; border: 1px solid #f0d97a; }

  a { color: var(--burgundy); text-decoration: none; }
  a:hover { text-decoration: underline; }

  .page-center {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 24px;
  }
  .form-card { width: 100%; max-width: 480px; }

  .divider {
    height: 3px;
    background: linear-gradient(90deg, var(--burgundy), var(--gold));
    border-radius: 2px;
    margin-bottom: 28px;
  }

  .page-title { font-size: 1.7rem; color: var(--ink); margin-bottom: 6px; }
  .page-sub { font-size: 0.88rem; color: var(--muted); margin-bottom: 28px; }

  .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px; }
  @media(max-width:520px){ .two-col { grid-template-columns: 1fr; } }
</style>
