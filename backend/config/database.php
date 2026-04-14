<?php
// GreenBulk Database Configuration

// Configuration for XAMPP Default Setup
$host = 'localhost';
$port = '3308'; // Final attempt to move to a unique port
$db   = 'greenbulk';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // In a production app, you might want to log this instead of outputting
     header('Content-Type: application/json');
     echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
     exit;
}

// Global CORS Headers for Development (Frontend on Vercel/Localhost)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}
?>
