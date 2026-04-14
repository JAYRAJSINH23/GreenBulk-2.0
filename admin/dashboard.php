<?php
require_once '../includes/db.php';
require_once '../includes/admin_only.php';

// Fetch Real Stats
try {
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?? 0;
    
    // Recent Orders
    $recentOrders = $pdo->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5")->fetchAll();
    
} catch (Exception $e) {
    die("Admin Error: " . $e->getMessage());
}

include '../includes/dashboard_layout.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Admin <span style="color: var(--primary-brown);">Overview</span></h2>
    <div style="background: white; padding: 10px 20px; border-radius: 10px; box-shadow: var(--shadow);">
        <span style="color: var(--text-light);">Total Revenue:</span> 
        <strong style="color: #1e7e34; font-size: 1.2rem;">$<?php echo number_format($totalRevenue, 2); ?></strong>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border-left: 5px solid var(--primary-brown);">
        <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-brown); opacity: 0.3; float: right;"></i>
        <p style="margin: 0; color: var(--text-light); font-size: 0.9rem;">Total Users</p>
        <h2 style="margin: 10px 0 0;"><?php echo number_format($totalUsers); ?></h2>
    </div>
    
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border-left: 5px solid #2196F3;">
        <i class="fas fa-box" style="font-size: 2rem; color: #2196F3; opacity: 0.3; float: right;"></i>
        <p style="margin: 0; color: var(--text-light); font-size: 0.9rem;">Products</p>
        <h2 style="margin: 10px 0 0;"><?php echo number_format($totalProducts); ?></h2>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border-left: 5px solid #FF9800;">
        <i class="fas fa-shopping-cart" style="font-size: 2rem; color: #FF9800; opacity: 0.3; float: right;"></i>
        <p style="margin: 0; color: var(--text-light); font-size: 0.9rem;">Total Orders</p>
        <h2 style="margin: 10px 0 0;"><?php echo number_format($totalOrders); ?></h2>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border-left: 5px solid #4CAF50;">
        <i class="fas fa-chart-line" style="font-size: 2rem; color: #4CAF50; opacity: 0.3; float: right;"></i>
        <p style="margin: 0; color: var(--text-light); font-size: 0.9rem;">Growth</p>
        <h2 style="margin: 10px 0 0;">+12%</h2>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 40px;">
    <!-- Recent Orders -->
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow);">
        <h3 style="margin-bottom: 25px;">Recent Orders</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px 0;">Customer</th>
                    <th style="padding: 15px 0;">Amount</th>
                    <th style="padding: 15px 0;">Status</th>
                    <th style="padding: 15px 0;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recentOrders as $order): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px 0;"><?php echo $order['name']; ?></td>
                    <td style="padding: 15px 0; font-weight: 700;">$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td style="padding: 15px 0;">
                        <span style="padding: 4px 10px; border-radius: 10px; font-size: 0.75rem; background: #e8f5e9; color: #2e7d32;"><?php echo $order['status']; ?></span>
                    </td>
                    <td style="padding: 15px 0; font-size: 0.85rem; color: var(--text-light);"><?php echo date('d M', strtotime($order['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($recentOrders)): ?>
                    <tr><td colspan="4" style="padding: 30px; text-align: center; color: var(--text-light);">No orders yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Quick Actions -->
    <div style="background: var(--primary-brown); color: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(111, 78, 55, 0.3);">
        <h3 style="margin-bottom: 25px; color: var(--skin-nude);">Quick Actions</h3>
        <div style="display: grid; gap: 15px;">
            <a href="manage-products.php" style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
            <a href="manage-users.php" style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-user-shield"></i> Manage Vendors
            </a>
            <a href="#" style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: white; text-decoration: none; display: flex; align-items: center; gap: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-file-invoice-dollar"></i> Export Sales Report
            </a>
        </div>
        
        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 0.8rem; opacity: 0.7;">GreenBulk Admin System v2.0</p>
        </div>
    </div>
</div>

</div> <!-- Close main-content from layout -->
</body>
</html>
