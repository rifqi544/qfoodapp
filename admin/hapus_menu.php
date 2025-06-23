<?php
require '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus gambar dari folder uploads (jika ada)
    $stmt = $conn->prepare("SELECT gambar FROM menu WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menu = $result->fetch_assoc();

    if ($menu && !empty($menu['gambar']) && file_exists("../uploads/" . $menu['gambar'])) {
        unlink("../uploads/" . $menu['gambar']);
    }

    // Hapus data menu dari database
    $delete = $conn->prepare("DELETE FROM menu WHERE id=?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: menu_admin.php");
exit;
