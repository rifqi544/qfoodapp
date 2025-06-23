<?php
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$conn = new mysqli("localhost", "root", "", "qfood");

$id = $conn->real_escape_string($_GET['id']);
$result = $conn->query("SELECT * FROM pesanan WHERE id_pesanan = '$id'");

if (!$result || $result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pembelian</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 20px;
    }
    .struk {
      max-width: 400px;
      margin: auto;
      border: 1px dashed #aaa;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 10px;
    }
    .info {
      margin-bottom: 10px;
    }
    .info strong {
      display: inline-block;
      width: 120px;
    }
    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 13px;
      color: #777;
    }
    @media print {
      button {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="struk">
    <h2>Q-FOOD</h2>
    <p style="text-align:center; margin-bottom:20px;">ID Pesanan: <strong><?= htmlspecialchars($data['id_pesanan']) ?></strong></p>
    <div class="info"><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></div>
    <div class="info"><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></div>
    <div class="info"><strong>Menu:</strong> <?= htmlspecialchars($data['menu']) ?></div>
    <div class="info"><strong>Jumlah:</strong> <?= $data['jumlah'] ?></div>
    <div class="info"><strong>Total:</strong> Rp <?= number_format($data['total'], 0, ',', '.') ?></div>
    <div class="info"><strong>Metode:</strong> <?= htmlspecialchars($data['metode_pembayaran']) ?></div>
    <div class="info"><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></div>
    <div class="info"><strong>No. WA:</strong> <?= htmlspecialchars($data['wa']) ?></div>
    

    <div class="footer">Terima kasih telah memesan di Q-FOOD!</div>
    <button onclick="window.print()">🖨 Cetak</button>
  </div>
</body>
</html>
