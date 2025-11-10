<?php
// login.php — versi tema hijau senada dashboard & register
require 'auth_simple.php';
$err = '';

// CSRF token (lab/demo)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $err = 'Invalid request (CSRF).';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $err = 'Username dan password wajib diisi.';
        } else {
            $pdo = pdo_connect();
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($u) {
                $ok = false;
                if (password_verify($password, $u['password'])) {
                    $ok = true;
                } elseif ($password === $u['password']) {
                    $ok = true;
                }

                if ($ok) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $u['id'];
                    unset($_SESSION['csrf_token']);
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $err = 'Login gagal: username atau password salah.';
                }
            } else {
                $err = 'Login gagal: username atau password salah.';
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login — Green Lab</title>

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

    body {
      background: linear-gradient(140deg, var(--bg1), var(--bg2));
      font-family: 'Inter', 'Segoe UI', sans-serif;
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .card-login {
      max-width: 420px;
      width: 100%;
      background: rgba(0, 30, 10, 0.45);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backdrop-filter: blur(12px);
      padding: 32px 28px;
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

    .card-title {
      color: var(--accent);
      font-weight: 700;
      text-align: center;
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
      border-radius: 10px;
      color: var(--text);
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

    .btn-primary {
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      border: none;
      border-radius: 10px;
      font-weight: 600;
      color: #04210e;
      transition: all 0.2s ease;
      padding: 12px;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(34,197,94,0.45);
    }

    .alert-danger {
      background: rgba(239,68,68,0.15);
      color: #fca5a5;
      border: 1px solid rgba(239,68,68,0.3);
      border-radius: 10px;
      text-align: center;
      font-size: 0.9rem;
      margin-bottom: 18px;
    }

    .form-footer {
      font-size: 0.9rem;
      color: var(--muted);
      text-align: center;
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

    .card-footer {
      border-top: 1px solid rgba(255,255,255,0.08);
      font-size: 0.85rem;
      color: var(--muted);
      text-align: center;
      margin-top: 20px;
      padding-top: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="card card-login">
    <div class="card-body p-0">
      <div class="text-center mb-3">
        <div class="brand">XSS</div>
        <h4 class="card-title mb-0">Selamat Datang</h4>
        <small class="text-muted">Masuk untuk melanjutkan</small>
      </div>

      <?php if($err): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($err); ?>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input id="username" name="username" class="form-control" placeholder="Masukkan username" required
                 value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label d-flex justify-content-between">
            <span>Password</span>
            <a href="#" class="small">Lupa password?</a>
          </label>
          <input id="password" name="password" type="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="d-grid">
          <button class="btn btn-primary" type="submit">Masuk</button>
        </div>
      </form>

      <div class="text-center mt-3 form-footer">
        <span>Belum punya akun? <a href="index.php">Daftar</a></span>
      </div>
    </div>

    <div class="card-footer small">
      ⚠️ Untuk keperluan lab: password bisa berupa plaintext.<br>
      Produksi wajib gunakan <code>password_hash()</code>.
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('username')?.focus();
  </script>
</body>
</html>
