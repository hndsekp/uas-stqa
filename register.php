<?php
include_once 'koneksi.php';

$error = "";
$success = "";

$email = "";
$username = "";

if (isset($_POST['register'])) {

    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!str_ends_with($email, '@upitra.ac.id')) {

        $error = "Email harus menggunakan domain @upitra.ac.id";

    } elseif ($password != $confirm) {

        $error = "Password tidak sama!";

    } elseif (!preg_match('/^(?=.*[\W_]).{8,}$/', $password)) {

        $error = "Password minimal 8 karakter dan harus mengandung simbol seperti & % $ #";

    } else {

        $cek = mysqli_query(
            $koneksi,
            "SELECT * FROM users
            WHERE username='$username' OR email='$email'"
        );

        if (mysqli_num_rows($cek) > 0) {

            $error = "Username atau email sudah digunakan!";

        } else {

            $password_hash = md5($password);

            mysqli_query(
                $koneksi,
                "INSERT INTO users (email, username, password)
                VALUES ('$email','$username','$password_hash')"
            );

            $success = "Registrasi berhasil! Silakan login.";

            $email = "";
            $username = "";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #0f1b2d;
            --navy-mid: #1a2d4a;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --border: rgba(255,255,255,0.08);
            --surface: rgba(255,255,255,0.04);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --danger: #ef4444;
            --success: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .register-container {
            width: 430px;
            background: var(--navy-mid);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 32px;
        }

        .logo {
            width: 56px;
            height: 56px;
            background: rgba(59,130,246,0.12);
            border: 1px solid rgba(59,130,246,0.25);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .logo svg {
            width: 26px;
            height: 26px;
            stroke: var(--accent);
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 28px;
        }

        .alert-error {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .alert-success {
            background: rgba(16,185,129,0.12);
            color: #34d399;
            border: 1px solid rgba(16,185,129,0.2);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        input {
            width: 100%;
            padding: 13px 15px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: white;
            font-size: 14px;
            font-family: inherit;
            transition: 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255,255,255,0.06);
        }

        input::placeholder {
            color: var(--text-secondary);
        }

        .checkbox-area {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .checkbox-area input {
            width: auto;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: var(--accent);
            color: white;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: var(--accent-hover);
        }

        .bottom-text {
            margin-top: 20px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .bottom-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .bottom-text a:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>

    <div class="register-container">

        <h2>Register</h2>
        <div class="subtitle">
            Buat akun baru untuk melanjutkan
        </div>

        <?php if ($error): ?>
            <div class="alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    placeholder="Email @upitra.ac.id"
                    value="<?= htmlspecialchars($email) ?>"
                    required>
            </div>

            <div class="form-group">
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    value="<?= htmlspecialchars($username) ?>"
                    required>
            </div>

            <div class="form-group">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required>
            </div>

            <div class="form-group">
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Ulangi Password"
                    required>
            </div>

            <div class="checkbox-area">
                <input type="checkbox" onclick="togglePassword()">
                <span>Lihat Password</span>
            </div>

            <button type="submit" name="register">
                Register
            </button>

        </form>

        <div class="bottom-text">
            Sudah punya akun?
            <a href="index.php">Login</a>
        </div>

    </div>

    <script>
        function togglePassword() {

            const pass = document.getElementById("password");
            const confirm = document.getElementById("confirm_password");

            if (pass.type === "password") {

                pass.type = "text";
                confirm.type = "text";

            } else {

                pass.type = "password";
                confirm.type = "password";
            }
        }
    </script>

</body>

</html>