<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background: #ffffff;
            width: 380px;
            padding: 32px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .register-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f2937;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #1d4ed8;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 8px;
        }

        .btn-register:hover {
            background: #15803d;
        }

        .register-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        .register-footer a {
            color: #2563eb;
            text-decoration: none;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 420px) {
            .register-card {
                width: 90%;
                padding: 24px;
            }
        }
    </style>

</head>
<body>

<div class="register-card">
    <h2>Registrasi Akun</h2>

    <form method="post" action="<?= BASEURL ?>/auth/register">
        <div class="form-group">
            <label>Username</label>
            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >
        </div>

        <div class="form-group">
            <label>Email</label>
            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirm"
                placeholder="Ulangi password"
                required
            >
        </div>

        <button type="submit" class="btn-register">
            Daftar
        </button>
    </form>

    <div class="register-footer">
        Sudah punya akun?
        <a href="<?= BASEURL ?>/auth/login">Login</a>
    </div>
</div>

</body>
</html>
