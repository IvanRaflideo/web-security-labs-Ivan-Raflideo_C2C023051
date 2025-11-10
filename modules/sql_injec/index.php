<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>SQL Injection Demo</title>
  <style>
    /* Reset */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }

    :root {
      /* Warna utama mengikuti tema dashboard hijau */
      --bg1: #0b2d10;
      --bg2: #104318;
      --panel: rgba(255, 255, 255, 0.04);
      --text: #ecfdf5;
      --muted: #a7f3d0;
      --accent: #4ade80;  /* hijau cerah */
      --accent-dark: #22c55e;
      --danger: #ef4444;
      --safe: #10b981;
      --radius: 12px;
      --shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background: linear-gradient(145deg, var(--bg1) 0%, var(--bg2) 100%);
      color: var(--text);
      padding: 36px 20px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      -webkit-font-smoothing: antialiased;
    }

    .wrap {
      width: 100%;
      max-width: 1100px;
    }

    header.top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 28px;
      animation: fadeIn 0.8s ease;
    }

    .brand {
      display: flex;
      gap: 14px;
      align-items: center;
    }

    .logo {
      width: 56px;
      height: 56px;
      border-radius: var(--radius);
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      display: flex;
      align-items: center;
      justify-content: center;
      color: #04210e;
      font-weight: 800;
      font-size: 18px;
      box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
    }

    .brand h1 {
      font-size: 22px;
      color: var(--text);
      margin-bottom: 4px;
      letter-spacing: 0.3px;
    }

    .brand p {
      color: var(--muted);
      font-size: 14px;
      margin: 0;
    }

    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: var(--radius);
      background: rgba(255, 255, 255, 0.05);
      color: var(--text);
      text-decoration: none;
      font-weight: 700;
      border: 1px solid rgba(255, 255, 255, 0.08);
      transition: all 0.2s ease;
    }
    .btn-back:hover {
      background: var(--accent-dark);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
    }

    /* Panel */
    .panel {
      background: var(--panel);
      border-radius: var(--radius);
      padding: 28px;
      box-shadow: var(--shadow);
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(8px);
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 20px;
    }

    /* Card */
    .card {
      background: linear-gradient(160deg, rgba(0, 0, 0, 0.2), rgba(0, 40, 0, 0.35));
      border-radius: var(--radius);
      padding: 22px;
      border: 1px solid rgba(255, 255, 255, 0.05);
      transition: all 0.25s ease;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 150px;
      text-decoration: none;
      color: var(--text);
    }

    .card:hover {
      transform: translateY(-6px);
      background: rgba(40, 120, 60, 0.35);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
    }

    .card .head {
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .chip {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: #032014;
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      box-shadow: 0 6px 14px rgba(34, 197, 94, 0.3);
    }

    .title {
      font-size: 18px;
      color: var(--accent);
      margin-bottom: 6px;
      font-weight: 700;
    }

    .desc {
      color: var(--muted);
      font-size: 14px;
      margin-bottom: 14px;
    }

    .foot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }

    .badge {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 12px;
    }

    .badge.safe {
      background: rgba(16, 185, 129, 0.15);
      color: var(--safe);
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .badge.vuln {
      background: rgba(239, 68, 68, 0.15);
      color: var(--danger);
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .link {
      text-decoration: none;
      background: rgba(255, 255, 255, 0.05);
      padding: 8px 12px;
      border-radius: 8px;
      color: var(--text);
      font-weight: 700;
      transition: background 0.2s ease;
    }

    .card:hover .link {
      background: var(--accent-dark);
      color: #fff;
    }

    /* About Section */
    .about {
      margin-top: 24px;
      background: rgba(0, 30, 10, 0.4);
      padding: 18px;
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      color: var(--muted);
      font-size: 14px;
      line-height: 1.6;
    }

    .about h2 {
      color: var(--accent);
      margin-bottom: 8px;
      font-size: 16px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
      .grid { grid-template-columns: 1fr; }
      body { padding: 20px; }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <header class="top">
      <div class="brand">
        <div class="logo">SQL</div>
        <div>
          <h1>SQL Injection Demo</h1>
          <p>Praktik keamanan dan demonstrasi kerentanan</p>
        </div>
      </div>

      <a class="btn-back" href="../../dashboard.php">← Kembali ke Dashboard</a>
    </header>

    <main class="panel">
      <div class="grid">
        <a class="card" href="login_safe.php">
          <div>
            <div class="head">
              <div class="chip">S</div>
              <div>
                <div class="title">Safe Login</div>
                <div class="desc">Login dengan proteksi SQL Injection (Prepared Statement)</div>
              </div>
            </div>
          </div>
          <div class="foot">
            <span class="badge safe">SAFE</span>
            <span class="link">Open →</span>
          </div>
        </a>

        <a class="card" href="login_vul.php">
          <div>
            <div class="head">
              <div class="chip">V</div>
              <div>
                <div class="title">Vulnerable Login</div>
                <div class="desc">Login rentan terhadap SQL Injection (untuk pembelajaran)</div>
              </div>
            </div>
          </div>
          <div class="foot">
            <span class="badge vuln">VULNERABLE</span>
            <span class="link">Open →</span>
          </div>
        </a>

        <a class="card" href="create_user_safe.php">
          <div>
            <div class="head">
              <div class="chip">C</div>
              <div>
                <div class="title">Safe User Creation</div>
                <div class="desc">Pembuatan user aman dengan validasi input dan prepared statements</div>
              </div>
            </div>
          </div>
          <div class="foot">
            <span class="badge safe">SAFE</span>
            <span class="link">Open →</span>
          </div>
        </a>

        <a class="card" href="create_user_vul.php">
          <div>
            <div class="head">
              <div class="chip">V</div>
              <div>
                <div class="title">Vulnerable User Creation</div>
                <div class="desc">Pembuatan user rentan terhadap SQL Injection (edukatif)</div>
              </div>
            </div>
          </div>
          <div class="foot">
            <span class="badge vuln">VULNERABLE</span>
            <span class="link">Open →</span>
          </div>
        </a>
      </div>

      <section class="about">
        <h2>Tentang Demo Ini</h2>
        <p>Halaman ini menunjukkan pentingnya melindungi aplikasi dari serangan SQL Injection.</p>
        <ul style="margin-top:10px; color:var(--muted);">
          <li><strong>Safe versions</strong> menggunakan prepared statements & validasi input.</li>
          <li><strong>Vulnerable versions</strong> memperlihatkan contoh celah keamanan untuk pembelajaran.</li>
        </ul>
        <p style="margin-top:12px;"><strong>Catatan:</strong> Versi yang rentan hanya untuk pembelajaran — jangan gunakan di server publik.</p>
      </section>
    </main>
  </div>
</body>
</html>
