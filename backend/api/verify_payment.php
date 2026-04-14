<?php
require_once '../config/database.php';

// backend/api/verify_payment.php

header('Content-Type: application/json');

define('RAZORPAY_KEY_SECRET', 'YOUR_SECRET_HERE'); // Must match create_order

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method is allowed");
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) throw new Exception("Invalid JSON input");

    $razorpay_order_id = $input['razorpay_order_id'];
    $razorpay_payment_id = $input['razorpay_payment_id'];
    $razorpay_signature = $input['razorpay_signature'];
    $local_order_id = $input['order_id'];

    // 1. Verify Signature locally
    $generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, RAZORPAY_KEY_SECRET);

    if (hash_equals($generated_signature, $razorpay_signature)) {
        // Payment is verified
        $stmt = $pdo->prepare("UPDATE orders SET status = 'Paid', razorpay_payment_id = ? WHERE id = ?");
        $stmt->execute([$razorpay_payment_id, $local_order_id]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Payment verified successfully'
        ]);
    } else {
        throw new Exception("Payment signature mismatch. Transaction may be fraudulent.");
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
