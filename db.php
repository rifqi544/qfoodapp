<?php
$conn = new mysqli("localhost", "root", "", "qfood");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
