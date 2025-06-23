<?php
session_start();
include 'db.php';

// Redirect jika sudah login
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: index.php");
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
  <title>Login Pengguna - Q-FOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #0195dd;
      --primary-dark: #0173ab;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(120deg, #0195dd, #0173ab);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: white;
      padding: 40px 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .login-box img {
      width: 100px;
      height: auto;
      margin-bottom: 10px;
    }

    .login-box h2 {
      margin-bottom: 25px;
      color: var(--primary);
    }

    .form-group {
      margin-bottom: 18px;
      text-align: left;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      background-color: #f9f9f9;
    }

    .form-group input:focus {
      border-color: var(--primary);
      outline: none;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background-color: var(--primary);
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }

    .login-btn:hover {
      background-color: var(--primary-dark);
    }

    .text-center {
      text-align: center;
      font-size: 14px;
      margin-top: 10px;
    }

    .text-center a {
      color: var(--primary);
      text-decoration: none;
    }

    .error {
      background: #ffe0e0;
      color: #d60000;
      padding: 8px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <!-- Tambahkan Logo -->
    <img src="assets/img/qfood.png" alt="Logo Q-FOOD">
    <h2>Login Q-FOOD</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
      </div>

      <div class="form-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
      </div>

      <button type="submit" class="login-btn">Masuk</button>
    </form>

    <div class="text-center">
      Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
  </div>
</body>
</html>
