<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}

$username = $_SESSION['user'];
$pesanan = [];

$stmt = $conn->prepare("SELECT id_pesanan, menu, jumlah, total, status, waktu, bukti_pengiriman FROM pesanan WHERE username = ? ORDER BY waktu DESC");
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pesanan[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lacak Pesanan - QFOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #d0f0ff, #ffffff);
      min-height: 100vh;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container {
      width: 100%;
      max-width: 900px;
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      text-align: center;
      font-size: 14px;
    }

    th {
      background-color: #0195dd;
      color: white;
    }

    tr:hover {
      background-color: #f3faff;
    }

    .badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 13px;
      text-transform: capitalize;
      display: inline-block;
      color: white;
    }

    .diproses { background-color: #ff9800; }
    .dikirim  { background-color: #03a9f4; }
    .selesai  { background-color: #4caf50; }
    .lainnya  { background-color: #999; }

    .progress-bar {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 6px;
      gap: 10px;
      position: relative;
    }

    .progress-bar::before {
      content: "";
      position: absolute;
      top: 50%;
      width: 100%;
      height: 4px;
      background: #ccc;
      z-index: 0;
      transform: translateY(-50%);
    }

    .icon-step {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #ccc;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      z-index: 1;
    }

    .icon-diproses { background-color: #ff9800; }
    .icon-dikirim  { background-color: #03a9f4; }
    .icon-selesai  { background-color: #4caf50; }
    .icon-menunggu { background-color: #999; }

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead tr {
        display: none;
      }

      td {
        position: relative;
        padding-left: 50%;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        top: 12px;
        font-weight: bold;
        color: #0195dd;
      }
    }
  </style>
</head>
<body>
  <a href="index.php" style="position: fixed; top: 20px; left: 20px; background-color: #0195dd; color: white; font-size: 20px; padding: 8px 12px; border-radius: 50%; text-decoration: none; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 999;">
    ←
  </a>

  <div class="container">
    <h2>Pesanan Anda</h2>

    <?php if (empty($pesanan)): ?>
      <p style="text-align:center; font-size:16px; color:#555;">Anda belum melakukan pesanan.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Status</th>
            <th>Waktu</th>
            <th>Bukti Pengiriman</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pesanan as $p): 
            $status = strtolower($p['status']);
            $kelas = 'lainnya';
            if ($status == 'diproses') $kelas = 'diproses';
            elseif ($status == 'dikirim') $kelas = 'dikirim';
            elseif ($status == 'selesai') $kelas = 'selesai';

            $step = 0;
            if ($status == 'diproses') $step = 1;
            elseif ($status == 'dikirim') $step = 2;
            elseif ($status == 'selesai') $step = 3;

            $icons = ['⏳', '🔧', '🚚', '✅'];
            $iconClasses = ['menunggu', 'diproses', 'dikirim', 'selesai'];
          ?>
            <tr>
              <td data-label="ID"><?= $p['id_pesanan'] ?></td>
              <td data-label="Menu"><?= htmlspecialchars($p['menu']) ?></td>
              <td data-label="Jumlah"><?= $p['jumlah'] ?></td>
              <td data-label="Total">Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
              <td data-label="Status">
                <div class="badge <?= $kelas ?>"><?= htmlspecialchars($p['status']) ?></div>
                <div class="progress-bar">
                  <?php foreach ($icons as $i => $icon): ?>
                    <div class="icon-step icon-<?= ($i === $step ? $iconClasses[$i] : 'menunggu') ?>"><?= $icon ?></div>
                  <?php endforeach; ?>
                </div>
              </td>
              <td data-label="Waktu"><?= $p['waktu'] ?></td>
              <td data-label="Pengiriman">
                <?php if (!empty($p['bukti_pengiriman'])): ?>
                  <a class="bukti-link" href="uploads/<?= $p['bukti_pengiriman'] ?>" target="_blank">Lihat</a>
                <?php else: ?>
                  Belum Upload
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
