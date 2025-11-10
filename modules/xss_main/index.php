<?php
// register.php (tema hijau senada dashboard)
require 'auth_simple.php';
$pdo = pdo_connect();
$msg = '';
$err = '';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');

    if($username && $password){
        try {
            // Lab: simpan plaintext (produksi wajib password_hash())
            $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name) VALUES (:u,:p,:n)");
            $stmt->execute([':u'=>$username, ':p'=>$password, ':n'=>$full_name]);
            $msg = "✅ User berhasil didaftarkan. Silakan login.";
        } catch (Exception $e) {
            $err = "❌ Registrasi gagal: kemungkinan username sudah dipakai.";
        }
    } else {
        $err = "Username & password wajib diisi.";
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register — Green Lab</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --bg1: #0b2d10;
      --bg2: #104318;
      --accent: #4ade80;
      --accent-dark: #22c55e;
      --text: #e8fdf5;
      --muted: #a7f3d0;
      --radius: 14px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    * { box-sizing: border-box; }

    body {
      background: linear-gradient(140deg, var(--bg1), var(--bg2));
      font-family: 'Inter', 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: var(--text);
    }

    .card-register {
      width: 100%;
      max-width: 430px;
      background: rgba(0, 30, 10, 0.45);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backdrop-filter: blur(12px);
      padding: 32px 30px;
      animation: fadeIn 0.8s ease;
    }

    .brand {
      width: 72px;
      height: 72px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      box-shadow: 0 6px 18px rgba(34, 197, 94, 0.4);
      font-weight: 700;
      font-size: 22px;
      color: #04210e;
      margin: 0 auto 14px;
    }

    h4.card-title {
      text-align: center;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 6px;
    }

    small.text-muted {
      display: block;
      text-align: center;
      color: var(--muted) !important;
      margin-bottom: 18px;
    }

    .form-label {
      font-weight: 500;
      color: var(--muted);
    }

    .form-control {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      color: var(--text);
      border-radius: 10px;
      padding: 10px;
      transition: all 0.2s ease;
    }

    .form-control::placeholder {
      color: #a7f3d0;
      opacity: 0.7;
    }

    .form-control:focus {
      border-color: var(--accent);
      background: rgba(255,255,255,0.12);
      box-shadow: 0 0 0 0.2rem rgba(34,197,94,0.25);
    }

    .btn-success {
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      border: none;
      border-radius: 10px;
      font-weight: 600;
      color: #04210e;
      transition: all 0.2s ease;
      padding: 12px;
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(34,197,94,0.45);
    }

    .alert {
      border-radius: 10px;
      padding: 10px 12px;
      margin-bottom: 16px;
      font-size: 0.9rem;
      text-align: center;
    }

    .alert-success {
      background: rgba(34,197,94,0.15);
      color: #bbf7d0;
      border: 1px solid rgba(34,197,94,0.3);
    }

    .alert-danger {
      background: rgba(239,68,68,0.15);
      color: #fca5a5;
      border: 1px solid rgba(239,68,68,0.3);
    }

    .text-center { text-align: center; }

    .small {
      font-size: 0.9rem;
      color: var(--muted);
    }

    a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    a:hover {
      color: var(--accent-dark);
      text-decoration: underline;
    }

    .back-btn {
      display: inline-block;
      text-align: center;
      text-decoration: none;
      width: 100%;
      padding: 10px 0;
      background: rgba(255,255,255,0.05);
      color: var(--text);
      border-radius: 10px;
      font-weight: 700;
      margin-top: 18px;
      border: 1px solid rgba(255,255,255,0.06);
      transition: all 0.2s ease;
    }

    .back-btn:hover {
      background: rgba(255,255,255,0.12);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }

    .card-footer {
      border-top: 1px solid rgba(255,255,255,0.08);
      margin-top: 18px;
      font-size: 0.85rem;
      color: var(--muted);
      text-align: center;
      padding-top: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="card card-register">
    <div class="card-body p-0">
      <div class="text-center mb-3">
        <div class="brand">REG</div>
        <h4 class="card-title">Buat Akun Baru</h4>
        <small class="text-muted">Isi form berikut untuk registrasi</small>
      </div>

      <?php if($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <?php if($err): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input id="username" name="username" class="form-control" placeholder="Pilih username unik" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" name="password" type="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="mb-3">
          <label for="full_name" class="form-label">Nama Lengkap</label>
          <input id="full_name" name="full_name" class="form-control" placeholder="Nama Anda">
        </div>

        <div class="d-grid">
          <button class="btn btn-success" type="submit">Daftar</button>
        </div>
      </form>

      <div class="text-center mt-3">
        <span class="small">Sudah punya akun? <a href="login.php">Login</a></span>
      </div>

      <a href="../../dashboard.php" class="back-btn">⬅ Kembali ke Dashboard</a>
    </div>

    <div class="card-footer">
      ⚠️ Lab demo: password disimpan plaintext.<br>Produksi wajib gunakan <code>password_hash()</code>.
    </div>
  </div>
</body>
</html>
