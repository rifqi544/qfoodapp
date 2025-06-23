<?php
session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_menu.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $filename);
        $gambar = $filename;
    }

    $stmt = $conn->prepare("INSERT INTO menu (nama, harga, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $harga, $gambar);
    $stmt->execute();

    header("Location: menu_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu - Admin QFOOD</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f2f9ff;
      padding: 30px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    h2 {
      text-align: center;
      color: #0195dd;
      margin-bottom: 25px;
    }
    label {
      display: block;
      margin-top: 15px;
      color: #333;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      background: #0195dd;
      color: white;
      border: none;
      padding: 10px;
      margin-top: 20px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
    }
    a.back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: white;
      background-color: #888;
      padding: 10px 20px;
      border-radius: 8px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Tambah Menu Makanan</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Nama Makanan</label>
      <input type="text" name="nama" required>

      <label>Harga</label>
      <input type="number" name="harga" required>

      <label>Gambar</label>
      <input type="file" name="gambar" accept="image/*" required>

      <button type="submit">Simpan Menu</button>
    </form>
    <a href="menu_admin.php" class="back">← Kembali</a>
  </div>
</body>
</html>
