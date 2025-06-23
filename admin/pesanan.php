<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "qfood");

// Update atau hapus pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status'], $_POST['id'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $conn->query("UPDATE pesanan SET status='$status' WHERE id_pesanan='$id'");
    }
}

$result = $conn->query("SELECT * FROM pesanan ORDER BY id_pesanan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan - Q-FOOD</title>
  <link rel="icon" href="assets/img/qfood.png" type="image/png">

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
      background: #f4f7fc;
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

    .sidebar.hidden {
      transform: translateX(-100%);
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
      margin-left: 10px;
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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background: #0195dd;
      color: white;
    }

    a.bukti-link {
      color: #0195dd;
      text-decoration: underline;
    }

    select, .status-btn, .hapus-btn {
      padding: 6px 10px;
      font-size: 13px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .status-btn {
      background-color: #0195dd;
      color: white;
      border: none;
      cursor: pointer;
    }

    .hapus-btn {
      background-color: #e74c3c;
      color: white;
      border: none;
      cursor: pointer;
    }

    .status-btn:hover {
      background-color: #017cb8;
    }

    .hapus-btn:hover {
      background-color: #c0392b;
    }

    select.status-belum { background-color: #f1c40f; color: white; }
    select.status-diproses { background-color: #ff9800; color: white; }
    select.status-dikirim { background-color: #03a9f4; color: white; }
    select.status-selesai { background-color: #4caf50; color: white; }

    @media (max-width: 768px) {
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
      <div style="display: flex; align-items: center;">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h2>Daftar Pesanan</h2>
      </div>
      <div class="logout">
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
      </div>
    </div>

    <table>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>WA</th>
        <th>Alamat</th>
        <th>Metode</th>
        <th>Status</th>
        <th>Bukti</th>
        <th>Pengiriman</th>
        <th>Tanggal</th>
        <th>Cetak</th>
      </tr>

      <?php
      $no = 1;
      while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>$no</td>";
          echo "<td>{$row['id_pesanan']}</td>";
          echo "<td>{$row['nama']}</td>";
          echo "<td>{$row['menu']}</td>";
          echo "<td>{$row['jumlah']}</td>";
          echo "<td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>";
          echo "<td>
        <a href='https://wa.me/" . preg_replace('/[^0-9]/', '', $row['wa']) . "' target='_blank' class='bukti-link'>
          Chat
        </a><br>
        {$row['wa']}
      </td>";

          echo "<td>{$row['alamat']}</td>";
          echo "<td>{$row['metode_pembayaran']}</td>";

          echo "<td><form method='POST' style='display:flex; gap:4px;'>";
          $statusClass = strtolower(str_replace(" ", "-", $row['status']));
          echo "<input type='hidden' name='id' value='{$row['id_pesanan']}'>";
          echo "<select name='status' class='status-{$statusClass}'>";
          foreach (["Belum Dibayar", "Diproses", "Dikirim", "Selesai"] as $s) {
              $selected = $row['status'] === $s ? 'selected' : '';
              echo "<option value='$s' $selected>$s</option>";
          }
          echo "</select> <button type='submit' class='status-btn'>✔</button></form></td>";

          echo "<td>";
          if (!empty($row['bukti_pembayaran'])) {
              echo "<a class='bukti-link' href='../uploads/{$row['bukti_pembayaran']}' target='_blank'>Lihat</a>";
          } else {
              echo "Belum Upload";
          }
          echo "</td>";
echo "<td>";
if (!empty($row['bukti_pengiriman'])) {
    echo "<a class='bukti-link' href='../uploads/{$row['bukti_pengiriman']}' target='_blank'>Lihat</a>";
} else {
    echo "<form method='POST' action='upload_pengiriman.php' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='id_pesanan' value='{$row['id_pesanan']}'>";
    echo "<input type='file' name='bukti_pengiriman' required>";
    echo "<button type='submit' class='status-btn'>Upload</button>";
    echo "</form>";
}
echo "</td>";

          echo "<td>" . date('d-m-Y H:i', strtotime($row['tanggal'])) . "</td>";
          echo "<td><a href='struk.php?id={$row['id_pesanan']}' target='_blank'>Cetak</a></td>";

          
          echo "</tr>";
          $no++;
      }
      ?>
    </table>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('hidden');
      document.getElementById('mainContent').classList.toggle('full');
    }
  </script>
</body>
</html>
