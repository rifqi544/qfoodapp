<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}
$username = $_SESSION['user'];
$menu = isset($_GET['menu']) ? $_GET['menu'] : '';
$harga = isset($_GET['harga']) ? $_GET['harga'] : '';
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pemesanan Q-FOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #0195dd;
      --primary-dark: #0173ab;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f8fc;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 500px;
      background: #fff;
      margin: 40px auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 25px;
      font-size: 24px;
    }

    label {
      display: block;
      margin: 12px 0 6px;
      font-weight: 500;
      font-size: 14px;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 10px 12px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      transition: 0.3s;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: var(--primary);
      outline: none;
    }

    textarea {
      resize: vertical;
    }

    .button {
      display: block;
      width: 100%;
      padding: 13px;
      margin-top: 25px;
      background: var(--primary);
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .button:hover {
      background: var(--primary-dark);
    }

    .total-display {
      margin-top: 20px;
      text-align: center;
      font-weight: bold;
      font-size: 18px;
      color: var(--primary);
      background: #f0faff;
      padding: 10px;
      border-radius: 8px;
    }

    footer {
      font-size: 13px;
      text-align: center;
      margin-top: 30px;
      color: #555;
    }

    .whatsapp-float {
      position: fixed;
      bottom: 65px;
      right: 20px;
      z-index: 999;
      background: none;
      border-radius: 50%;
      transition: transform 0.2s;
      cursor: pointer;
      text-align: center;
    }

    .whatsapp-float:hover {
      transform: scale(1.1);
    }

    .whatsapp-float img {
      width: 48px;
      height: 48px;
    }

    .wa-text {
      position: fixed;
      bottom: 20px;
      right: 12px;
      background: #25D366;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: bold;
      font-family: 'Poppins', sans-serif;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    @media (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 20px;
      }

      h2 {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Form Pemesanan Q-FOOD</h2>
    <form action="simpan_pesanan.php" method="POST" id="formPesan">

      <label for="nama">Nama Pelanggan:</label>
      <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" required>

      <label for="menu">Menu:</label>
      <input type="text" id="menu" name="menu" value="<?= htmlspecialchars($menu) ?>" readonly>

      <label for="harga">Harga (Rp):</label>
      <input type="text" id="harga" name="harga" value="<?= htmlspecialchars($harga) ?>" readonly>

      <label for="jumlah">Jumlah:</label>
      <input type="number" id="jumlah" name="jumlah" min="1" required>

      <label for="total">Total Harga (Rp):</label>
      <input type="text" id="total" name="total" readonly>

      <label for="alamat">Alamat Pengiriman:</label>
      <textarea id="alamat" name="alamat" rows="3" required></textarea>

      <label for="catatan">Catatan Tambahan:</label>
      <textarea id="catatan" name="catatan" rows="2"></textarea>

      <label for="wa">Nomor WhatsApp:</label>
      <input type="text" id="wa" name="wa" placeholder="Contoh: 087788131822" required>

      <label for="metode_pembayaran">Metode Pembayaran:</label>
      <select id="metode_pembayaran" name="metode_pembayaran" required>
        <option value="">-- Pilih Metode --</option>
        <option value="COD">COD (Bayar di Tempat)</option>
        <option value="QRIS">QRIS</option>
      </select>
      
      
      <div class="total-display" id="totalDisplay">Total: Rp 0</div>


      <button type="submit" class="button">Kirim Pesanan</button>
    </form>
  </div>

  <footer>
    &copy; <?= date("Y") ?> Q-FOOD. All rights reserved.
  </footer>

  <!-- Tombol WhatsApp -->
  <div class="whatsapp-float" onclick="kirimKeWhatsApp()">
    <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="Chat WhatsApp">
  </div>
  <div class="wa-text" onclick="kirimKeWhatsApp()">Chat Admin</div>

  <script>
    const hargaInput = document.getElementById('harga');
    const jumlahInput = document.getElementById('jumlah');
    const totalInput = document.getElementById('total');
    const totalDisplay = document.getElementById('totalDisplay');

    jumlahInput.addEventListener('input', function () {
      const harga = parseFloat(hargaInput.value.replace(/\./g, '').replace(',', '.')) || 0;
      const jumlah = parseInt(jumlahInput.value) || 0;
      const total = harga * jumlah;

      const formatted = total.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
      });

      totalInput.value = formatted;
      totalDisplay.textContent = `Total: ${formatted}`;
    });

    function kirimKeWhatsApp() {
      const nama = document.getElementById("nama").value;
      const menu = document.getElementById("menu").value;
      const harga = document.getElementById("harga").value;
      const jumlah = document.getElementById("jumlah").value;
      const total = document.getElementById("total").value;
      const alamat = document.getElementById("alamat").value;
      const catatan = document.getElementById("catatan").value;
      const wa = document.getElementById("wa").value;
      const metode = document.getElementById("metode_pembayaran").value;

      const pesan = `Halo Admin Q-FOOD! Saya ingin memesan:\n\n` +
        `Nama: ${nama}\n` +
        `Menu: ${menu}\n` +
        `Harga: ${harga}\n` +
        `Jumlah: ${jumlah}\n` +
        `Total: ${total}\n` +
        `Alamat: ${alamat}\n` +
        `Catatan: ${catatan}\n` +
        `Metode Pembayaran: ${metode}\n` +
        `No. WA Saya: ${wa}`;

      const encodedPesan = encodeURIComponent(pesan);
      const nomorAdmin = "6287788131822";
      const link = `https://wa.me/${nomorAdmin}?text=${encodedPesan}`;
      window.open(link, '_blank');
    }
  </script>
</body>
</html>
