<?php
require 'db.php';
$pesan = '';
$sukses = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama     = trim($_POST['nama']);
    $wa       = trim($_POST['no_wa']);
    $alamat   = trim($_POST['alamat']);

    $cek = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $pesan = "Username sudah digunakan.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, nama_lengkap, no_wa, alamat) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $nama, $wa, $alamat);
        if ($stmt->execute()) {
            $sukses = true;
        } else {
            $pesan = "Registrasi gagal. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun - Q-FOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #e8f4fc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: #fff;
      padding: 35px 30px;
      border-radius: 12px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 25px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.3s;
    }

    input:focus, textarea:focus {
      outline: none;
      border-color: #0195dd;
    }

    button {
      width: 100%;
      background: #0195dd;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 12px;
      transition: background 0.3s;
    }

    button:hover {
      background: #0173ab;
    }

    .message {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-top: 10px;
    }

    .login-link {
      text-align: center;
      margin-top: 18px;
      font-size: 14px;
    }

    .login-link a {
      color: #0195dd;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Daftar Akun</h2>

    <?php if (!empty($pesan)): ?>
      <div class="message"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="text" name="no_wa" placeholder="Nomor WhatsApp" required>
      <textarea name="alamat" placeholder="Alamat Lengkap" rows="3" required></textarea>
      <button type="submit">Daftar</button>
    </form>

    <div class="login-link">
      Sudah punya akun? <a href="login_user.php">Login di sini</a>
    </div>
  </div>

  <?php if ($sukses): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil Daftar!',
        text: 'Silakan login dengan akun Anda.',
        confirmButtonText: 'Login Sekarang'
      }).then(() => {
        window.location.href = 'login_user.php';
      });
    </script>
  <?php endif; ?>
</body>
</html>
