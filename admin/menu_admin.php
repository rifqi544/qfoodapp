<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require '../db.php';
$result = $conn->query("SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Menu - Admin QFOOD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      display: flex;
      background: #f2f9ff;
    }

    .sidebar {
      width: 220px;
      background: #0195dd;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      left: 0;
      top: 0;
      transition: all 0.3s;
      z-index: 999;
    }
    .sidebar h2 {
      color: white;
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      padding: 15px 20px;
    }
    .sidebar ul li a {
      color: white;
      text-decoration: none;
      display: block;
    }
    .sidebar ul li:hover {
      background: #017cb8;
    }
    .sidebar.hidden {
      transform: translateX(-100%);
    }

    .main-content {
      margin-left: 220px;
      padding: 20px;
      width: calc(100% - 220px);
      transition: margin-left 0.3s, width 0.3s;
    }
    .main-content.full {
      margin-left: 0;
      width: 100%;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      padding: 10px 20px;
      border-bottom: 1px solid #ccc;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .header h2 {
      color: #0195dd;
    }
    .logout a {
      text-decoration: none;
      background: #e74c3c;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
    }
    .toggle-btn {
      font-size: 20px;
      background: none;
      border: none;
      color: #0195dd;
      cursor: pointer;
      margin-right: 15px;
    }

    .container {
      max-width: 100%;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    h3 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #0195dd;
      color: white;
    }
    img {
      width: 80px;
      border-radius: 8px;
    }
    a.btn {
      padding: 8px 14px;
      margin: 2px;
      display: inline-block;
      text-decoration: none;
      color: white;
      border-radius: 6px;
    }
    .btn-tambah { background-color: #4caf50; }
    .btn-edit { background-color: #ff9800; }
    .btn-hapus { background-color: #f44336; }

    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        z-index: 1000;
      }
      .main-content {
        margin-left: 0;
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <h2>Q-FOOD</h2>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="pesanan.php">Pesanan</a></li>
      <li><a href="menu_admin.php">Kelola Menu</a></li>
    </ul>
  </div>

  <div class="main-content" id="mainContent">
    <div class="header">
      <div style="display:flex; align-items:center;">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h2>Kelola Menu</h2>
      </div>
      <div class="logout">
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
      </div>
    </div>

    <div class="container">
      <a href="tambah_menu.php" class="btn btn-tambah">+ Tambah Menu</a>

      <table>
        <thead>
          <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><img src="../uploads/<?= $row['gambar'] ?>" alt=""></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td>
              <?= $row['stok'] > 0 ? '<span style="color:green;">Tersedia</span>' : '<span style="color:red;">Habis</span>' ?>
            </td>
            <td>
              <a href="edit_menu.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
              <a href="hapus_menu.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus menu ini?')" class="btn btn-hapus">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('mainContent');
      sidebar.classList.toggle('hidden');
      content.classList.toggle('full');
    }
  </script>
</body>
</html>
