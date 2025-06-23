<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "qfood");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pesanan'];

    if ($_FILES['bukti_pengiriman']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['bukti_pengiriman']['tmp_name'];
        $name = time() . "_" . basename($_FILES['bukti_pengiriman']['name']);
        $target = "../uploads/" . $name;

        if (move_uploaded_file($tmp_name, $target)) {
            $conn->query("UPDATE pesanan SET bukti_pengiriman='$name' WHERE id_pesanan='$id'");
        }
    }
}

header("Location: pesanan.php");
exit;
?>
