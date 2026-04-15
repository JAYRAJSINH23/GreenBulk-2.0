<?php
require_once 'includes/db.php';

// Category mapping to folder names and counts
$config = [
    'Creatines'   => ['folder' => 'creatine',    'count' => 10, 'prefix' => 'Pure Micronized Creatine'],
    'Preworkout'  => ['folder' => 'pre-workout', 'count' => 10, 'prefix' => 'Explosive Pre-Workout'],
    'Fit Foods'   => ['folder' => 'oats',        'count' => 4,  'prefix' => 'Premium Rolled Oats'],
    'Proteins'    => ['folder' => 'whey',        'count' => 7,  'prefix' => 'Nitro Whey Isolate'],
    'Gym Clothes' => ['folder' => 'clothes',     'count' => 7,  'prefix' => 'Elite Performance Tee'],
    'Accessories' => ['folder' => 'accessories', 'count' => 7,  'prefix' => 'Leak-Proof Shaker']
];

try {
    // 1. Clear old products
    $pdo->exec("DELETE FROM products");
    $pdo->exec("ALTER TABLE products AUTO_INCREMENT = 1");
    echo "Staging area cleared. Preparing to load new inventory...\n";

    // 2. Prepare statement
    $stmt = $pdo->prepare("INSERT INTO products (name, category, price, description, image_url) VALUES (?, ?, ?, ?, ?)");

    $totalInserted = 0;
    foreach ($config as $dbCat => $data) {
        for ($i = 1; $i <= $data['count']; $i++) {
            $name = $data['prefix'] . " Gen-" . $i;
            $price = rand(49, 199) + 0.99; // Premium pricing
            $desc = "Professional grade $dbCat. Specially formulated for peak muscle recovery, metabolic efficiency, and elite-level performance gains.";
            
            // PATH: assets/images/products/{folder}/{i}.png
            $imgUrl = "assets/images/products/" . $data['folder'] . "/" . $i . ".png";
            
            $stmt->execute([$name, $dbCat, $price, $desc, $imgUrl]);
            $totalInserted++;
        }
    }

    echo "✅ SUCCESS! " . $totalInserted . " products added with category-wise images.\n";
    echo "Website is now LIVE with real stock! 🚀";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage();
}
