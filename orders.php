<?php
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    $orders = $stmt->fetchAll();
} catch (Exception $e) {
    $orders = [];
}

include 'includes/header.php';
?>

<div style="max-width: 900px; margin: 0 auto; padding: 40px 0;">
    <h2 style="margin-bottom: 30px; color: var(--primary-brown);">My Order History</h2>

    <?php if (empty($orders)): ?>
        <div style="text-align: center; padding: 80px; background: var(--beige-accent); border-radius: 20px;">
            <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
            <h3>No orders found.</h3>
            <a href="products.php" class="btn btn-primary" style="margin-top: 20px;">Start Shopping</a>
        </div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div style="background: white; border: 1px solid #eee; border-radius: 15px; overflow: hidden; margin-bottom: 30px; box-shadow: var(--shadow);">
                <div style="padding: 20px; background: #fdfdfd; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-light); text-transform: uppercase;">Order #GB-<?php echo $order['id']; ?></span>
                        <p style="margin: 5px 0 0; font-weight: 600;"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                    </div>
                    <div style="text-align: right;">
                        <span style="padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; background: <?php echo $order['status'] == 'Paid' ? '#e8f5e9' : '#fff3e0'; ?>; color: <?php echo $order['status'] == 'Paid' ? '#2e7d32' : '#ef6c00'; ?>;">
                            <?php echo $order['status']; ?>
                        </span>
                        <h3 style="margin: 5px 0 0; color: var(--primary-brown);">$<?php echo number_format($order['total_amount'], 2); ?></h3>
                    </div>
                </div>

                <div style="padding: 20px;">
                    <?php
                    $itemStmt = $pdo->prepare("SELECT oi.*, p.name, p.image_url FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                    $itemStmt->execute([$order['id']]);
                    $items = $itemStmt->fetchAll();
                    ?>
                    
                    <div style="display: grid; gap: 15px;">
                        <?php foreach ($items as $item): ?>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 50px; height: 50px; background: #f5f5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?php echo $item['image_url']; ?>" style="max-width: 80%; max-height: 80%;">
                                </div>
                                <div style="flex: 1;">
                                    <h5 style="margin: 0;"><?php echo $item['name']; ?></h5>
                                    <span style="font-size: 0.8rem; color: var(--text-light);"><?php echo $item['quantity']; ?> x $<?php echo number_format($item['price'], 2); ?></span>
                                </div>
                                <div style="font-weight: 600;">
                                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div style="padding: 15px 20px; background: #fdfdfd; border-top: 1px solid #eee; text-align: right;">
                    <button class="btn btn-outline" style="padding: 8px 15px; font-size: 0.85rem;">Need Help?</button>
                    <button class="btn btn-primary" style="padding: 8px 15px; font-size: 0.85rem;">Buy Again</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
