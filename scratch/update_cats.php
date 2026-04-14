<?php
require_once 'includes/db.php';
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $pdo->exec("UPDATE products SET category = 'Proteins' WHERE category IN ('Protein', 'Mass Gainer')");
    $pdo->exec("UPDATE products SET category = 'Preworkout' WHERE category = 'Pre-Workout'");
    $pdo->exec("UPDATE products SET category = 'Fit Foods' WHERE category IN ('Vegan', 'Superfoods')");
    $pdo->exec("UPDATE products SET category = 'Creatines' WHERE category = 'Bulk'");
    
    // Distribute Accessories and Clothes randomly/evenly
    $pdo->exec("UPDATE products SET category = 'Accessories', name = 'Premium Shaker Bottle', image_url = 'https://images.unsplash.com/photo-1593095948071-474c5cc2989d?w=800' WHERE id % 7 = 0");
    $pdo->exec("UPDATE products SET category = 'Gym Clothes', name = 'Elite Performance Tee', image_url = 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800' WHERE id % 9 = 0");
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "Categories updated successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
