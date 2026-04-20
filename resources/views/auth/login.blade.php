<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Desa Kalipait</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 380px;
            padding: 35px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            color: white;
            animation: fadeIn 0.8s ease-in-out;
        }

        h3 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            border: none;
            padding: 12px;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: white;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        .btn-login {
            background: #00c6ff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #0072ff;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="login-card">

    <h3><i class="bi bi-shield-lock"></i> Login Admin</h3>

    @if(session('success'))
        <div class="alert alert-success text-dark" id="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-dark" id="alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf

        <!-- NIK -->
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK" required>
        </div>

        <!-- Password -->
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
            <span class="input-group-text" id="togglePassword">
                <i class="bi bi-eye-slash"></i>
            </span>
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>

    <div class="footer-text">
        © 2026 Desa Kalipait
    </div>
</div>

<script>
    // Show / Hide Password
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            password.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });

    // Auto hide alert
    setTimeout(() => {
        document.getElementById('alert-success')?.remove();
        document.getElementById('alert-error')?.remove();
    }, 3000);
</script>

</body>
</html>