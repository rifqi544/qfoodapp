<?php
require '../db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$menu = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $detail = $_POST['detail'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar = $menu['gambar'];

    if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = time() . "_menu." . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $filename);
        $gambar = $filename;
    }

    $update = $conn->prepare("UPDATE menu SET nama=?, detail=?, harga=?, stok=?, gambar=? WHERE id=?");
    $update->bind_param("ssdisi", $nama, $detail, $harga, $stok, $gambar, $id);
    $update->execute();

    header("Location: menu_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Menu</title>
  <style>
    body { font-family: Arial; background: #f0f0f0; padding: 30px; }
    .form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
    input, textarea, select { width: 100%; padding: 10px; margin-top: 10px; border-radius: 6px; border: 1px solid #ccc; }
    button { background: #0195dd; color: white; padding: 10px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; }
  </style>
</head>
<body>
  <div class="form">
    <h2>Edit Menu</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Nama</label>
      <input type="text" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" required>
      
      <label>Detail</label>
      <textarea name="detail"><?= htmlspecialchars($menu['detail']) ?></textarea>
      
      <label>Harga</label>
      <input type="number" name="harga" value="<?= $menu['harga'] ?>" required>

      <label>Stok</label>
      <select name="stok">
        <option value="1" <?= $menu['stok'] == 1 ? 'selected' : '' ?>>Tersedia</option>
        <option value="0" <?= $menu['stok'] == 0 ? 'selected' : '' ?>>Habis</option>
      </select>

      <label>Gambar Baru (opsional)</label>
      <input type="file" name="gambar">

      <?php if (!empty($menu['gambar'])): ?>
        <p><img src="../uploads/<?= $menu['gambar'] ?>" width="100"></p>
      <?php endif; ?>

      <button type="submit">Simpan</button>
    </form>
  </div>
</body>
</html>
