<?php
// FILE: import_db.php
require_once 'includes/config.php';

echo "<div style='font-family: \"Outfit\", sans-serif; padding: 40px; border-radius: 15px; margin: 50px auto; max-width: 600px; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;'>";

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    
    // GLOBAL OVERRIDE
    $pdo->exec("SET SESSION FOREIGN_KEY_CHECKS = 0;");

    // 1. CLEANUP
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table` CASCADE");
    }

    // 2. Import Schema
    if (file_exists('database/COMPLETE_DATABASE.sql')) {
        $sql = file_get_contents('database/COMPLETE_DATABASE.sql');
        // Strip out any SET FOREIGN_KEY_CHECKS that might interfere
        $sql = preg_replace('/SET FOREIGN_KEY_CHECKS\s*=\s*1/i', 'SET FOREIGN_KEY_CHECKS = 0', $sql);
        $sql = preg_replace('/DROP DATABASE IF EXISTS greenbulk;/i', '', $sql);
        $sql = preg_replace('/CREATE DATABASE greenbulk;/i', '', $sql);
        $pdo->exec($sql);
    }
    
    // 3. Import Seed Data
    if (file_exists('database/seed_125_items.sql')) {
        $seed = file_get_contents('database/seed_125_items.sql');
        // CRITICAL: Strip any "SET FOREIGN_KEY_CHECKS = 1" that might turn it back on mid-file
        $seed = preg_replace('/SET FOREIGN_KEY_CHECKS\s*=\s*1/i', 'SET FOREIGN_KEY_CHECKS = 0', $seed);
        
        $pdo->exec($seed);
        $msg = "Bhai, Setup Complete! 125 products loaded successfully.";
    }

    $pdo->exec("SET SESSION FOREIGN_KEY_CHECKS = 1;");

    echo "<h2 style='color: #1e7e34;'>✅ Ho Gaya Bhai!</h2>";
    echo "<p style='color: #555; line-height: 1.6;'>$msg</p>";
    echo "<div style='margin-top: 30px;'>
            <a href='index.php' style='padding: 12px 25px; background: #6F4E37; color: white; text-decoration: none; border-radius: 5px; font-weight: 600;'>Store Par Jao</a>
          </div>";

} catch (Exception $e) {
    echo "<h2 style='color: #ff4d4d;'>❌ Kuch Gadbad Hui</h2>";
    echo "<p style='color: #555; background: #fff5f5; padding: 15px; border-radius: 8px; font-size: 0.9rem; text-align: left;'><b>Error:</b> " . $e->getMessage() . "</p>";
    echo "<div style='margin-top: 20px;'><button onclick='location.reload()' style='padding: 8px 15px; cursor:pointer;'>Try Again</button></div>";
}

echo "</div>";
?>
