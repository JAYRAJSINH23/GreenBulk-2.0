<?php
require_once '../includes/auth.php';
include '../includes/header.php';
?>

<div style="display: flex; gap: 40px; margin-top: 30px;">
    <aside style="width: 250px;">
        <div style="background: var(--white); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow);">
            <div style="padding: 20px; text-align: center; background: var(--beige-accent);">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=6F4E37&color=E8CFC1" style="width: 80px; border-radius: 50%; margin-bottom: 10px;">
                <h4 style="margin: 0;"><?php echo $_SESSION['user_name']; ?></h4>
            </div>
            <div style="padding: 10px 0;">
                <a href="dashboard.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--text-dark);">My Dashboard</a>
                <a href="orders.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--primary-brown); font-weight: 600; background: var(--beige-accent); border-left: 4px solid var(--primary-brown);">My Orders</a>
                <a href="profile.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--text-dark);">Profile Settings</a>
                <a href="../logout.php" style="display: block; padding: 12px 25px; text-decoration: none; color: #ff4d4d;">Logout</a>
            </div>
        </div>
    </aside>

    <div style="flex: 1;">
        <h2 style="margin-bottom: 30px;">My Orders</h2>
        
        <table style="width: 100%; border-collapse: collapse; background: var(--white); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow);">
            <thead>
                <tr style="background: var(--beige-accent); color: var(--primary-brown);">
                    <th style="padding: 15px; text-align: left;">Order #</th>
                    <th style="padding: 15px; text-align: left;">Date</th>
                    <th style="padding: 15px; text-align: left;">Status</th>
                    <th style="padding: 15px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">ORD-10023</td>
                    <td style="padding: 15px;">Apr 12, 2026</td>
                    <td style="padding: 15px;"><span style="color: #1e7e34; background: #e6f4ea; padding: 2px 10px; border-radius: 10px; font-size: 0.8rem;">Delivered</span></td>
                    <td style="padding: 15px; text-align: right; font-weight: 700;">$85.50</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">ORD-10056</td>
                    <td style="padding: 15px;">Apr 14, 2026</td>
                    <td style="padding: 15px;"><span style="color: #b7791f; background: #fff4e5; padding: 2px 10px; border-radius: 10px; font-size: 0.8rem;">Shipped</span></td>
                    <td style="padding: 15px; text-align: right; font-weight: 700;">$120.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
