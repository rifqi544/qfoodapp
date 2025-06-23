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
  <title>Profil Saya - QFOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #dff4ff, #f8fbfd);
      padding: 40px 20px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.7s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 20px;
      font-size: 26px;
    }

    .profile-photo {
      text-align: center;
      margin-bottom: 25px;
    }

    .profile-photo img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #0195dd;
      box-shadow: 0 5px 12px rgba(0,0,0,0.1);
    }

    .profile-item {
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile-item i {
      color: #0195dd;
      font-size: 18px;
      width: 24px;
      text-align: center;
    }

    .profile-item label {
      font-weight: bold;
      color: #444;
      flex: 1;
    }

    .profile-item .value {
      flex: 2;
      background: #f0f6fa;
      padding: 10px 14px;
      border-radius: 8px;
      color: #333;
      font-size: 15px;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      margin-top: 30px;
    }

    .buttons a {
      flex: 1;
      background: #0195dd;
      color: white;
      text-align: center;
      text-decoration: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: bold;
      transition: 0.3s;
    }

    .buttons a:hover {
      background: #017bb5;
    }

    @media (max-width: 480px) {
      .profile-item {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2><i class="fas fa-user-circle"></i> Profil Saya</h2>

    <div class="profile-photo">
      <img src="uploads/<?= !empty($user['foto_profil']) ? $user['foto_profil'] : 'default.png' ?>" alt="Foto Profil">
    </div>

    <div class="profile-item">
      <i class="fas fa-user"></i>
      <label>Nama Lengkap</label>
      <div class="value"><?= htmlspecialchars($user['nama_lengkap']) ?></div>
    </div>

    <div class="profile-item">
      <i class="fab fa-whatsapp"></i>
      <label>No. WhatsApp</label>
      <div class="value"><?= htmlspecialchars($user['no_wa']) ?></div>
    </div>

    <div class="profile-item">
      <i class="fas fa-envelope"></i>
      <label>Email</label>
      <div class="value"><?= htmlspecialchars($user['email']) ?></div>
    </div>

    <div class="profile-item">
      <i class="fas fa-id-badge"></i>
      <label>Username</label>
      <div class="value"><?= htmlspecialchars($user['username']) ?></div>
    </div>

    <div class="buttons">
      <a href="edit_propil.php"><i class="fas fa-edit"></i> Edit Profil</a>
      <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
    </div>
  </div>
</body>
</html>
