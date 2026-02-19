<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Y GRO Student Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2440 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff; border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3); padding: 2.5rem;
            width: 100%; max-width: 420px;
        }
        .logo-box {
            width: 56px; height: 56px; border-radius: 12px;
            background: #f59e0b; display: flex; align-items: center;
            justify-content: center; font-weight: 800; color: #1e3a5f; font-size: 1.4rem;
            margin: 0 auto 1rem;
        }
        .form-control:focus { border-color: #1e3a5f; box-shadow: 0 0 0 .2rem rgba(30,58,95,.15); }
        .btn-login {
            background: #1e3a5f; color: #fff; width: 100%;
            padding: .65rem; font-weight: 600; border-radius: 8px; border: none;
        }
        .btn-login:hover { background: #162c4a; color: #fff; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <div class="logo-box">YG</div>
        <h4 class="fw-700 mb-1" style="color:#1e3a5f;">Y GRO SMS</h4>
        <p class="text-muted small mb-0">Student Management System</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', 'admin@ygro.lk') }}" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary small">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label small" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>
    <p class="text-center text-muted mt-4 small">© 2026 Y GRO Organization</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
