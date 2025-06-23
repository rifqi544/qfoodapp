<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "qfood");

// Total pesanan
$totalPesanan = $conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc()['total'];

// Total pendapatan
$totalPendapatan = $conn->query("SELECT SUM(total) as total FROM pesanan")->fetch_assoc()['total'];

// Pesanan hari ini
$hariIni = date('Y-m-d');
$pesananHariIni = $conn->query("SELECT COUNT(*) as total FROM pesanan WHERE DATE(tanggal) = '$hariIni'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Q-FOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      background: #f4f4f4;
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

    .cards {
      display: flex;
      gap: 20px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .card {
      flex: 1;
      min-width: 250px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .card h3 {
      color: #555;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 24px;
      color: #0195dd;
      font-weight: bold;
    }

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
        <h2>Dashboard Admin</h2>
      </div>
      <div class="logout">
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
      </div>
    </div>

    <div class="cards">
      <div class="card">
        <h3>Total Pesanan</h3>
        <p><?= $totalPesanan ?></p>
      </div>
      <div class="card">
        <h3>Total Pendapatan</h3>
        <p>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></p>
      </div>
      <div class="card">
        <h3>Pesanan Hari Ini</h3>
        <p><?= $pesananHariIni ?></p>
      </div>
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
