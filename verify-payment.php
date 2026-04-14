<?php
require_once 'includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['payment_id'])) {
    header("Location: index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$paymentId = $_GET['payment_id'];
$totalAmount = $_GET['total'];
$cart = $_SESSION['cart'];

try {
    $pdo->beginTransaction();

    // 1. Create Final Order with Status Paid
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, razorpay_payment_id) VALUES (?, ?, 'Paid', ?)");
    $stmt->execute([$userId, $totalAmount, $paymentId]);
    $orderId = $pdo->lastInsertId();

    // 2. Fetch product prices and create Order Items
    $productIds = implode(',', array_keys($cart));
    $stmtProducts = $pdo->query("SELECT id, price FROM products WHERE id IN ($productIds)");
    $products = $stmtProducts->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);

    $stmtItems = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $id => $qty) {
        if (isset($products[$id])) {
            $stmtItems->execute([$orderId, $id, $qty, $products[$id]['price']]);
        }
    }

    $pdo->commit();
    unset($_SESSION['cart']);

    // Redirect to success page
    header("Location: process-payment.php?success=1&order_ref=$orderId");
    exit();

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Verification Error: " . $e->getMessage());
}
?>
