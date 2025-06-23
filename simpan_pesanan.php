<?php
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    die("Anda belum login.");
}

// Koneksi
$conn = new mysqli("localhost", "root", "", "qfood");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pesanan terakhir dan buat ID baru dengan format QF###
$result = $conn->query("SELECT id_pesanan FROM pesanan ORDER BY id_pesanan DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $lastId = $result->fetch_assoc()['id_pesanan'];
    $lastNum = intval(substr($lastId, 2)); // Ambil angka setelah 'QF'
    $newId = 'QF' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
} else {
    $newId = 'QF001';
}

// Ambil data dari form
$nama     = $_POST['nama'];
$menu     = $_POST['menu'];
$harga    = floatval(str_replace(['Rp', '.', ','], '', $_POST['harga']));
$jumlah   = intval($_POST['jumlah']);
$total    = $harga * $jumlah;
$alamat   = $_POST['alamat'];
$catatan  = $_POST['catatan'];
$wa       = $_POST['wa'];
$metode   = $_POST['metode_pembayaran'];
$username = $_SESSION['user']; // ✅ PERBAIKAN DI SINI

// Atur status otomatis berdasarkan metode
switch ($metode) {
    case "COD":
        $status = "Diproses";
        break;
    case "Transfer Bank":
        $status = "Menunggu Konfirmasi";
        break;
    case "QRIS":
        $status = "Menunggu Pembayaran";
        break;
    default:
        $status = "Belum Dibayar";
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO pesanan 
    (id_pesanan, nama, menu, harga, jumlah, total, alamat, catatan, wa, metode_pembayaran, username, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdiissssss", $newId, $nama, $menu, $harga, $jumlah, $total, $alamat, $catatan, $wa, $metode, $username, $status);

if ($stmt->execute()) {
    if ($metode === "QRIS") {
        header("Location: qris_pembayaran.php?id=$newId");
    } else {
        echo "<script>alert('Pesanan berhasil dikirim!'); window.location='index.php';</script>";
    }
} else {
    echo "Gagal menyimpan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
