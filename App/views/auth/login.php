<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

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

        /* CARD LOGIN */
        .login-card {
            background: #ffffff;
            width: 360px;
            padding: 32px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f2937;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 18px;
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

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .login-footer {
            margin-top: 18px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
        }

        .login-footer a {
            color: #2563eb;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 400px) {
            .login-card {
                width: 90%;
                padding: 24px;
            }
        }
    </style>

</head>
<body>

<div class="login-card">
    <h2>Login</h2>

    <form method="post" action="<?= BASEURL ?>/auth/login">
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
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
        </div>

        <button type="submit" class="btn-login">
            Login
        </button>
    </form>

    <div class="login-footer">
        Belum punya akun?
        <a href="<?= BASEURL ?>/auth/register">Daftar</a>
    </div>
</div>

</body>
</html>
