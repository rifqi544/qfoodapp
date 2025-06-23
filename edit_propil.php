<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}

$username = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil - QFOOD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f8ff;
      margin: 0;
      padding: 20px;
    }

    .container {
      background: white;
      max-width: 500px;
      margin: auto;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 20px;
    }

    .profile-photo {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile-photo img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #0195dd;
    }

    .form-item {
      margin-bottom: 18px;
    }

    .form-item label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #555;
    }

    .form-item input[type="text"],
    .form-item input[type="email"],
    .form-item input[type="password"],
    .form-item input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      background: #f9f9f9;
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 25px;
    }

    .buttons button,
    .buttons a {
      padding: 10px;
      border-radius: 8px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      background: #0195dd;
      color: white;
      border: none;
      cursor: pointer;
    }

    .buttons a {
      background: #ccc;
      color: #333;
    }

    .buttons button:hover {
      background: #017cb8;
    }

    .buttons a:hover {
      background: #bbb;
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
      }

      .container {
        padding: 20px;
      }

      .profile-photo img {
        width: 100px;
        height: 100px;
      }

      .buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Profil Saya</h2>

    <div class="profile-photo">
      <img src="uploads/<?= !empty($user['foto_profil']) ? $user['foto_profil'] : 'default.png' ?>" alt="Foto Profil">
    </div>

    <form action="proses_edit_propil.php" method="POST" enctype="multipart/form-data">
      <div class="form-item">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
      </div>

      <div class="form-item">
        <label for="no_wa">No. WhatsApp</label>
        <input type="text" id="no_wa" name="no_wa" value="<?= htmlspecialchars($user['no_wa']) ?>" required>
      </div>

      <div class="form-item">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div class="form-item">
        <label for="foto_profil">Ganti Foto Profil</label>
        <input type="file" name="foto_profil" id="foto_profil" accept="image/*">
      </div>

    

      <div class="buttons">
        <button type="submit">Simpan Perubahan</button>
        <a href="propil.php">Kembali</a>
      </div>
    </form>
  </div>
</body>
</html>
