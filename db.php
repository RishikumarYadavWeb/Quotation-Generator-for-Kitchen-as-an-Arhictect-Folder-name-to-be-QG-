$host = $_ENV['MYSQLHOST'] ?? 'localhost';
$username = $_ENV['MYSQLUSER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? '';
$database = $_ENV['MYSQLDATABASE'] ?? 'quotation_new';
$port = $_ENV['MYSQLPORT'] ?? 3306;

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database,
    $port
);