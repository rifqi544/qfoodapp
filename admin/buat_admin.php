<?php
$conn = new mysqli("localhost", "root", "", "qfood");

$username = 'admin';
$password_plain = '123456';
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password_hash);

if ($stmt->execute()) {
    echo "✅ Akun admin berhasil dibuat!<br>";
    echo "Username: <b>$username</b><br>";
    echo "Password: <b>$password_plain</b>";
} else {
    echo "❌ Gagal membuat akun: " . $stmt->error;
}
?>
