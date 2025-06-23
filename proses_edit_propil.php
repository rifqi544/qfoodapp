<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit;
}

$username = $_SESSION['user'];

$nama = $_POST['nama_lengkap'];
$email = $_POST['email'];
$no_wa = $_POST['no_wa'];
$alamat = $_POST['alamat'];

// Handle foto profil (optional)
$fotoBaru = '';
if (!empty($_FILES['foto_profil']['name'])) {
    $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
    $fotoBaru = time() . "_profil." . $ext;
    move_uploaded_file($_FILES['foto_profil']['tmp_name'], "uploads/" . $fotoBaru);
    
    // Update dengan foto
    $stmt = $conn->prepare("UPDATE users SET nama_lengkap=?, email=?, no_wa=?, alamat=?, foto_profil=? WHERE username=?");
    $stmt->bind_param("ssssss", $nama, $email, $no_wa, $alamat, $fotoBaru, $username);
} else {
    // Update tanpa foto
    $stmt = $conn->prepare("UPDATE users SET nama_lengkap=?, email=?, no_wa=?, alamat=? WHERE username=?");
    $stmt->bind_param("sssss", $nama, $email, $no_wa, $alamat, $username);
}

if ($stmt->execute()) {
    header("Location: propil.php");
} else {
    echo "Gagal update profil.";
}
?>
