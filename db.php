<?php
$host = getenv("mysql.railway.internal") ?: "your_mysql_host_here";
$port = getenv("3306") ?: "your_mysql_port_here";
$user = getenv("root") ?: "your_mysql_user_here";
$password = getenv("KVxrVlHxERBNEiELjoMKgxoiOKbbnRMo") ?: "your_mysql_password_here";
$database = getenv("railway") ?: "your_mysql_database_here";

// Create connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
