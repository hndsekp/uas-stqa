<?php
session_start();
include 'koneksi.php';

$error = "";

if (isset($_POST['login'])) {

    $user = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM users 
        WHERE (username='$user' OR email='$user') 
        AND password='$password'"
    );

    if (mysqli_num_rows($query) === 1) {

        $data = mysqli_fetch_assoc($query);

        $_SESSION['username'] = $data['username'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

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
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --danger: #ef4444;
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

        .login-container {
            width: 400px;
            background: var(--navy-mid);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 32px;
        }

        h2 {
            text-align: center;
            margin-bottom: 28px;
            font-size: 24px;
        }

        input {
            width: 100%;
            padding: 13px 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.04);
            color: white;
            font-size: 14px;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
        }

        input::placeholder {
            color: var(--text-secondary);
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
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: var(--accent-hover);
        }

        .error {
            background: rgba(239,68,68,0.12);
            color: #f87171;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .bottom-text {
            margin-top: 18px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .bottom-text a {
            color: var(--accent);
            text-decoration: none;
        }

        .checkbox {
            margin-bottom: 16px;
            font-size: 13px;
            color: var(--text-secondary);
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h2>Login UPITRA</h2>

        <?php if ($error): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <input type="text" name="username" placeholder="Username atau Email" required>

            <input type="password" id="password" name="password" placeholder="Password" required>

            <div class="checkbox">
                <input type="checkbox" onclick="togglePassword()" style="width:auto;">
                Lihat Password
            </div>

            <button type="submit" name="login">
                Login
            </button>

        </form>

        <div class="bottom-text">
            Belum punya akun?
            <a href="register.php">Register</a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");

            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>

</body>

</html>