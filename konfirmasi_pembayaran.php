<?php
$id = $_POST['id'];
$conn = new mysqli("localhost", "root", "", "qfood");
$conn->query("UPDATE pesanan SET status='Menunggu Konfirmasi' WHERE id='$id'");
echo "<script>alert('Terima kasih, pembayaran Anda sedang diproses!'); window.location='index.php';</script>";
?>
