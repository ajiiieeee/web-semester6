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
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 400px;
            padding: 30px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header-login {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-login h3 {
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .header-login p {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 0;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
        }

        .input-group-text {
            background: #e9ecef;
            border-radius: 8px 0 0 8px;
        }

        .btn-login {
            background: #198754;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: bold;
            color: white;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #157347;
        }

        .alert {
            font-size: 14px;
            border-radius: 8px;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #999;
        }

        .logo-desa {
            width: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="header-login">
        <!-- Logo (opsional) -->
        <!-- <img src="/logo-desa.png" class="logo-desa"> -->

        <h3>Login Sistem Desa</h3>
        <p>Desa Kalipait</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" id="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" id="alert-error">
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
            <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                <i class="bi bi-eye-slash"></i>
            </span>
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-login w-100">Masuk</button>
    </form>

    <div class="footer-text">
        © 2026 Pemerintah Desa Kalipait
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