<?php
$id = $_GET['id'] ?? '';
$conn = new mysqli("localhost", "root", "", "qfood");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$data = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>QRIS Pembayaran - QFOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #e3f2fd, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .box {
      background: white;
      padding: 40px 30px;
      max-width: 480px;
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    h2 {
      color: #0195dd;
      font-weight: 600;
      margin-bottom: 10px;
    }

    h2 i {
      margin-right: 8px;
      color: #017bb5;
    }

    h3 {
      margin: 8px 0 20px;
      color: #333;
      font-size: 22px;
    }

    img {
      width: 100%;
      max-width: 280px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: #0195dd;
      color: white;
      padding: 12px 22px;
      font-size: 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin: 8px 5px;
      transition: 0.3s;
      text-decoration: none;
    }

    .button:hover {
      background: #017bb5;
    }

    .green {
      background: #4CAF50;
    }

    .green:hover {
      background: #3ea043;
    }

    p.note {
      margin-top: 12px;
      font-size: 13px;
      color: #555;
    }

    .error {
      background: #fff3f3;
      color: #e74c3c;
      padding: 15px 25px;
      border-radius: 10px;
      font-weight: 500;
      text-align: center;
    }
  </style>
</head>
<body>
  <?php if ($data): ?>
    <div class="box">
      <h2><i class="fas fa-qrcode"></i> Scan QRIS Pembayaran</h2>
      <p>Total yang harus dibayar:</p>
      <h3>Rp <?= number_format($data['total'], 0, ',', '.') ?></h3>

      <img src="assets/img/qrisqfood.jpg" alt="QRIS Pembayaran">

      <form action="upload_bukti_form.php" method="GET" style="display:inline;">
        <input type="hidden" name="id" value="<?= $data['id_pesanan'] ?>">
        <button type="submit" class="button"><i class="fas fa-upload"></i> Kirim Bukti</button>
      </form>

      <form action="konfirmasi_pembayaran.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?= $data['id_pesanan'] ?>">
        <button type="submit" class="button green"><i class="fas fa-check-circle"></i> Saya Sudah Bayar</button>
      </form>

      <p class="note">Pastikan bukti pembayaran Anda telah dikirim sebelum klik tombol "Saya Sudah Bayar".</p>
    </div>
  <?php else: ?>
    <div class="error">
      <i class="fas fa-times-circle"></i> Data pesanan tidak ditemukan atau ID salah.
    </div>
  <?php endif; ?>
</body>
</html>
