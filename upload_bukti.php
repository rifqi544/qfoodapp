<?php
$conn = new mysqli("localhost", "root", "", "qfood");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir);

        $fileTmp = $_FILES['bukti']['tmp_name'];
        $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
        $fileName = 'bukti_' . time() . '_' . rand(100,999) . '.' . $ext;
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $destination)) {
            // ✅ Ubah id ke id_pesanan
            $stmt = $conn->prepare("UPDATE pesanan SET bukti_pembayaran = ? WHERE id_pesanan = ?");
            if (!$stmt) {
                die("Prepare gagal: " . $conn->error);
            }

            $stmt->bind_param("ss", $fileName, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Bukti pembayaran berhasil diunggah!'); window.location.href='qris_pembayaran.php?id=$id';</script>";
            } else {
                echo "❌ Gagal update ke database: " . $stmt->error;
            }
        } else {
            echo "❌ Gagal memindahkan file.";
        }
    } else {
        echo "❌ File tidak dipilih atau terjadi error upload.";
    }
} else {
    echo "❌ Metode tidak valid.";
}
?>
