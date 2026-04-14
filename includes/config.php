<?php
// GreenBulk Configuration
define('BASE_URL', '/GreenBulk');
define('DB_HOST', 'localhost');
define('DB_PORT', '3308'); // Adjust if your XAMPP uses 3306
define('DB_NAME', 'greenbulk');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
