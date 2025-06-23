<?php
session_start();
require 'db.php';

// Akses hanya admin (opsional: cek session admin)
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

// Proses update status jika ada permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_pesanan.php"); // Reload setelah update
    exit;
}

// Ambil semua pesanan
$pesanan = $conn->query("SELECT * FROM pesanan ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Kelola Pesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 20px;
      background: #f4f8fc;
    }

    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      border-radius: 10px;
      overflow: hidden;
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

    form {
      display: flex;
      justify-content: center;
    }

    select {
      padding: 5px 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
    }

    button {
      padding: 6px 10px;
      margin-left: 5px;
      background: #0195dd;
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
    }

    button:hover {
      background-color: #0173ab;
    }

    tr:hover {
      background: #f0faff;
    }
  </style>
</head>
<body>
  <h2>Kelola Pesanan - Admin</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Status</th>
        <th>Ubah Status</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      <?php while($p = $pesanan->fetch_assoc()): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['nama']) ?></td>
          <td><?= htmlspecialchars($p['menu']) ?></td>
          <td><?= $p['jumlah'] ?></td>
          <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
          <td><?= $p['status'] ?></td>
          <td>
            <form method="POST">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <select name="status">
                <option value="Menunggu Pembayaran" <?= $p['status']=='Menunggu Pembayaran'?'selected':'' ?>>Menunggu</option>
                <option value="Diproses" <?= $p['status']=='Diproses'?'selected':'' ?>>Diproses</option>
                <option value="Dikirim" <?= $p['status']=='Dikirim'?'selected':'' ?>>Dikirim</option>
                <option value="Selesai" <?= $p['status']=='Selesai'?'selected':'' ?>>Selesai</option>
              </select>
              <button type="submit">Ubah</button>
            </form>
          </td>
          <td><?= $p['waktu'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
