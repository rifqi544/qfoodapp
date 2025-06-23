<?php
$host = 'centerbeam.proxy.rlwy.net'; // dari "host" di URL MySQL Railway
$port = 58148;                        // dari "port" di URL
$user = 'root';                      // dari "user" di URL
$pass = 'slEkPzynjxRTjrHNOiFYPvuZfgdPPSae';                // dari "password" di URL, bisa klik "show" untuk lihat
$db   = 'railway';                   // biasanya nama DB-nya memang 'railway'

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
