<?php
// Halaman publik, tidak perlu login
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Kami - Q-FOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e0f2f1, #ffffff);
      color: #333;
    }

    .container {
      max-width: 900px;
      margin: 50px auto;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .logo {
      display: block;
      margin: 0 auto 20px;
      width: 100px;
    }

    h1 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 10px;
    }

    h2 {
      color: #017cb8;
      margin-top: 30px;
    }

    p {
      text-align: justify;
      font-size: 16px;
      line-height: 1.7;
      margin: 15px 0;
    }

    ul {
      margin-left: 20px;
      font-size: 15px;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 13px;
      color: #777;
    }

    .btn {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 25px;
      background-color: #0195dd;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
    }

    .btn:hover {
      background-color: #017cb8;
    }

    @media screen and (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 25px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <img src="assets/img/qfood.png" alt="Q-FOOD Logo" class="logo">
  <h1>Tentang Kami</h1>

  <p><strong>Q-FOOD</strong> adalah aplikasi pemesanan makanan online yang dikembangkan untuk mempermudah proses pemesanan makanan secara digital, cepat, dan efisien. Dengan Q-FOOD, pengguna dapat memilih menu favorit, melakukan pembayaran, dan memantau status pesanan mereka langsung dari perangkat mereka.</p>

  <h2>Visi Kami</h2>
  <p>Menjadi solusi digital terbaik dalam layanan pemesanan makanan online di lingkungan lokal maupun nasional, dengan pengalaman pengguna yang cepat, mudah, dan terpercaya.</p>

  <h2>Misi Kami</h2>
  <ul>
    <li>Memudahkan pelanggan memesan makanan tanpa harus keluar rumah</li>
    <li>Memberikan platform yang aman dan nyaman untuk transaksi</li>
    <li>Mendukung pelaku UMKM kuliner dalam digitalisasi layanan mereka</li>
    <li>Menyediakan fitur lengkap untuk pelanggan dan admin</li>
  </ul>

  <h2>Apa yang Kami Tawarkan?</h2>
  <ul>
    <li>Pemesanan makanan secara online dengan form praktis</li>
    <li>Status pemesanan real-time: Belum Bayar, Diproses, Dikirim, Selesai</li>
    <li>Upload bukti pembayaran dan bukti pengiriman</li>
    <li>Cetak struk otomatis dan laporan admin harian/bulanan</li>
    <li>Notifikasi dan konfirmasi melalui WhatsApp</li>
  </ul>

  <h2>Dikembangkan Oleh</h2>
  <p><strong>MUHAMAD RIFQI AL-MUHSI</strong><br>
  Alumni SMK YASPI AL-FALAH - Jurusan PPLG<br>
  Tahun Ajaran 2022–2025</p>

  <a href="index.php" class="btn">← Kembali ke Beranda</a>

  <div class="footer">
    &copy; <?= date("Y") ?> Q-FOOD. All rights reserved.
  </div>
</div>

</body>
</html>
