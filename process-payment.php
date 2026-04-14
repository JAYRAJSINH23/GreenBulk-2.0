<?php
require_once 'includes/db.php';

$orderRef = $_GET['order_ref'] ?? 'N/A';

include 'includes/header.php';
?>

<div style="text-align: center; padding: 100px 5%; max-width: 800px; margin: 0 auto;">
    <div style="width: 120px; height: 120px; background: #1e7e34; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 4rem; margin: 0 auto 30px; box-shadow: 0 10px 30px rgba(30, 126, 52, 0.3);">
        <i class="fas fa-check"></i>
    </div>
    
    <h1 style="color: var(--text-dark); margin-bottom: 20px; font-size: 2.5rem;">Payment Successful!</h1>
    <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.6; margin-bottom: 40px;">
        Thank you! Your transaction was successful. Order Reference: <strong>#GB-<?php echo $orderRef; ?></strong>.
    </p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 50px;">
        <div style="background: var(--beige-accent); padding: 30px; border-radius: 20px; text-align: left;">
            <h4 style="margin-bottom: 15px; color: var(--primary-brown);"><i class="fas fa-box"></i> Order status</h4>
            <p style="font-size: 0.9rem; color: var(--text-light);">We are preparing your items for shipping.</p>
        </div>
        <div style="background: var(--beige-accent); padding: 30px; border-radius: 20px; text-align: left;">
            <h4 style="margin-bottom: 15px; color: var(--primary-brown);"><i class="fas fa-truck"></i> Estimated Arrival</h4>
            <p style="font-size: 0.9rem; color: var(--text-light);">Expected delivery within 48-72 hours.</p>
        </div>
    </div>

    <div style="display: flex; gap: 15px; justify-content: center;">
        <a href="orders.php" class="btn btn-primary" style="padding: 18px 40px;">View My Orders</a>
        <a href="index.php" class="btn btn-outline" style="padding: 18px 40px;">Main Menu</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
