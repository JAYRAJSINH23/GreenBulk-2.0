<?php
require_once '../config/database.php';

// backend/api/create_order.php

header('Content-Type: application/json');

// NOTE: Replace with your actual Razorpay Test Keys
define('RAZORPAY_KEY_ID', 'rzp_test_YOUR_KEY_HERE');
define('RAZORPAY_KEY_SECRET', 'YOUR_SECRET_HERE');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method is allowed");
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) throw new Exception("Invalid JSON input");

    $items = $input['items'];
    $total = floatval($input['total']);
    $customer = $input['customer'];

    // 1. Create Order in Razorpay via cURL (Framework-free)
    $order_data = [
        'receipt'         => 'rcpt_' . time(),
        'amount'          => $total * 100, // Amount in paise
        'currency'        => 'INR',
        'payment_capture' => 1 // Auto-capture
    ];

    $ch = curl_init('https://api.razorpay.com/v1/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($order_data));
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        throw new Exception("Razorpay order creation failed: " . $response);
    }

    $razor_order = json_decode($response, true);
    $razorpay_order_id = $razor_order['id'];

    // 2. Store Order in MySQL
    // For this demo, we'll associate with User ID 1 if not logged in, or handle as guest logic
    $user_id = 1; 

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, razorpay_order_id, total_amount, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->execute([$user_id, $razorpay_order_id, $total]);
    $order_id = $pdo->lastInsertId();

    // 3. Store Order Items
    $stmt_items = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmt_items->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
    }

    $pdo->commit();

    echo json_encode([
        'status' => 'success',
        'order_id' => $order_id,
        'razorpay_order_id' => $razorpay_order_id,
        'amount' => $order_data['amount']
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
