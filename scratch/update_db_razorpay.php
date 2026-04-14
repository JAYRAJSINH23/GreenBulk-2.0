<?php
require_once 'includes/db.php';
try {
    $pdo->exec("ALTER TABLE orders ADD COLUMN IF NOT EXISTS razorpay_order_id VARCHAR(255) NULL, ADD COLUMN IF NOT EXISTS razorpay_payment_id VARCHAR(255) NULL");
    echo "Database updated successfully for Razorpay!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
