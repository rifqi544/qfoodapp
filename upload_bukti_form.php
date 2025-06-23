<?php
$id = $_GET['id'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Upload Bukti Pembayaran - QFOOD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(to bottom right, #0195dd, #eaf6ff);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px 20px;
    }

    .box {
      background: white;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      max-width: 480px;
      width: 100%;
      text-align: center;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      color: #0195dd;
      margin-bottom: 25px;
    }

    h2 i {
      margin-right: 10px;
      color: #017bb5;
    }

    .upload-area {
      border: 2px dashed #0195dd;
      border-radius: 12px;
      padding: 30px;
      cursor: pointer;
      transition: 0.3s;
      position: relative;
      background: #f0faff;
    }

    .upload-area:hover {
      background: #e3f4ff;
      transform: scale(1.02);
    }

    .upload-area i {
      font-size: 48px;
      color: #0195dd;
      margin-bottom: 12px;
    }

    .upload-area input[type="file"] {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    #file-name {
      margin-top: 15px;
      font-size: 14px;
      color: #555;
    }

    .preview {
      margin-top: 15px;
      max-height: 180px;
      border-radius: 8px;
      display: none;
    }

    .button {
      margin-top: 25px;
      padding: 12px 25px;
      background: #0195dd;
      color: white;
      border: none;
      font-size: 15px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .button:hover {
      background: #017bb5;
    }

    .button i {
      margin-right: 8px;
    }

    footer {
      margin-top: 40px;
      text-align: center;
      font-size: 13px;
      color: #666;
    }

    footer span {
      color: #0195dd;
      font-weight: 600;
    }

    @media(max-width: 500px) {
      .box {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="box">
    <h2><i class="fas fa-money-check-dollar"></i> Upload Bukti Pembayaran</h2>
    <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

      <label class="upload-area">
        <i class="fas fa-file-arrow-up"></i><br>
        Klik untuk memilih bukti pembayaran
        <input type="file" name="bukti" id="bukti" accept="image/*" required onchange="updatePreview()">
      </label>

      <div id="file-name">Belum ada file dipilih</div>
      <img id="preview-image" class="preview" src="#" alt="Preview Gambar">

      <button type="submit" class="button"><i class="fas fa-paper-plane"></i> Upload Sekarang</button>
    </form>
  </div>

  <footer>
    &copy; <?= date('Y') ?> <span>QFOOD</span>. All right reserved
  </footer>

  <script>
    function updatePreview() {
      const input = document.getElementById('bukti');
      const file = input.files[0];
      const fileName = file ? file.name : 'Belum ada file dipilih';
      document.getElementById('file-name').textContent = fileName;

      const preview = document.getElementById('preview-image');
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.style.display = 'none';
      }
    }
  </script>
</body>
</html>
