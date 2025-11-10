<?php
// Tidak perlu session_start() karena sudah tidak menggunakan login
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DVWA DEO Dashboard</title>

  <!-- CSS dimasukkan langsung di sini -->
  <style>
  /* ==== VIBRANT FUTURISTIC DASHBOARD STYLE ==== */
  :root {
    /* Palet warna baru: biru-ungu-neon */
    --bg-1: #0f0c29;
    --bg-2: #34632bff;
    --bg-3: #24243e;
    --card: rgba(255, 255, 255, 0.08);
    --card-hover: rgba(255, 255, 255, 0.15);
    --text: #f8fafc;
    --muted: #d1d5db;
    --accent: #60a5fa;   /* biru neon */
    --accent-2: #a78bfa; /* ungu lembut */
    --accent-3: #22d3ee; /* cyan cerah */
    --shadow: 0 8px 30px rgba(0,0,0,0.5);
    --radius: 18px;
    --max-w: 1200px;
    --gap: 24px;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
  }

  * { box-sizing: border-box; }

  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, var(--bg-1), var(--bg-2), var(--bg-3));
    background-size: 300% 300%;
    animation: gradientMove 12s ease infinite;
    color: var(--text);
    -webkit-font-smoothing: antialiased;
    line-height: 1.6;
  }

  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  /* Container */
  .container {
    max-width: var(--max-w);
    margin: 50px auto;
    padding: 20px;
  }

  /* Header */
  .header {
    text-align: left;
    margin-bottom: calc(var(--gap) * 2);
    animation: fadeIn 1s ease;
  }

  .header h1 {
    margin: 0 0 10px 0;
    font-size: 2.8rem;
    font-weight: 800;
    background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
    background-size: 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowMove 4s linear infinite;
    letter-spacing: 1.2px;
  }

  @keyframes glowMove {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
  }

  .header p {
    color: var(--muted);
    font-size: 1.1rem;
    margin: 0;
  }

  /* Modules Grid */
  .modules-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: var(--gap);
    padding: 20px 0;
  }

  /* Module Cards */
  .module-card {
    background: var(--card);
    border-radius: var(--radius);
    padding: 28px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    backdrop-filter: blur(12px);
    text-decoration: none;
    display: block;
    color: inherit;
    position: relative;
    overflow: hidden;
  }

  .module-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -80%;
    width: 50%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.2), transparent);
    transform: skewX(-20deg);
    transition: left 0.8s;
  }

  .module-card:hover::before {
    left: 130%;
  }

  .module-card:hover {
    transform: translateY(-8px);
    background: var(--card-hover);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.6);
  }

  .module-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--accent);
    margin-bottom: 12px;
    transition: color 0.3s ease;
  }

  .module-card:hover .module-title {
    color: var(--accent-3);
  }

  .module-desc {
    color: var(--muted);
    font-size: 0.95rem;
    line-height: 1.5;
  }

  /* Hover Arrow */
  .module-title::after {
    content: "→";
    opacity: 0;
    margin-left: 6px;
    transition: all 0.3s ease;
  }

  .module-card:hover .module-title::after {
    opacity: 1;
    margin-left: 10px;
  }

  /* Animations */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Active */
  .module-card:active { transform: scale(0.98); }

  /* Responsive */
  @media (max-width: 768px) {
    .container { padding: 16px; margin: 30px auto; }
    .header h1 { font-size: 2.2rem; }
    .modules-grid { grid-template-columns: 1fr; }
    .module-card { padding: 24px; }
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>DASHBOARD DVWA </h1>
      <p>Selamat datang di Lab Keamanan Web</p>
    </div>

    <div class="modules-grid">
      <a href="modules/sql_injec/" class="module-card">
        <div class="module-title">SQL Injection Lab</div>
        <div class="module-desc">Praktik SQL Injection dan cara mengamankannya</div>
      </a>

      <a href="modules/xss_main/" class="module-card">
        <div class="module-title">XSS Lab</div>
        <div class="module-desc">Pembelajaran Cross-Site Scripting (XSS)</div>
      </a>

      <a href="modules/broken_acces/" class="module-card">
        <div class="module-title">Broken Access Lab</div>
        <div class="module-desc">Uji kerentanan kontrol akses</div>
      </a>

      <a href="modules/kerentangan_upload/" class="module-card">
        <div class="module-title">File Upload Lab</div>
        <div class="module-desc">Praktik keamanan upload file</div>
      </a>
    </div>
  </div>
</body>
</html>
