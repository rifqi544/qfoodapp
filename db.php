$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$name = getenv("DB_NAME");
$port = getenv("DB_PORT");

$conn = new mysqli($host, $user, $pass, $name, $port);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
