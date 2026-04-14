<?php
require_once '../includes/auth.php';
include '../includes/header.php';
?>

<div style="display: flex; gap: 40px; margin-top: 30px;">
    <!-- Client Sidebar -->
    <aside style="width: 250px;">
        <div style="background: var(--white); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow);">
            <div style="padding: 20px; text-align: center; background: var(--beige-accent);">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=6F4E37&color=E8CFC1" style="width: 80px; border-radius: 50%; margin-bottom: 10px;">
                <h4 style="margin: 0;"><?php echo $_SESSION['user_name']; ?></h4>
                <p style="font-size: 0.8rem; color: var(--text-light);">Member since 2026</p>
            </div>
            <div style="padding: 10px 0;">
                <a href="dashboard.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--primary-brown); font-weight: 600; background: var(--beige-accent); border-left: 4px solid var(--primary-brown);">My Dashboard</a>
                <a href="orders.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--text-dark);">My Orders</a>
                <a href="profile.php" style="display: block; padding: 12px 25px; text-decoration: none; color: var(--text-dark);">Profile Settings</a>
                <a href="../logout.php" style="display: block; padding: 12px 25px; text-decoration: none; color: #ff4d4d;">Logout</a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div style="flex: 1;">
        <h2 style="margin-bottom: 30px;">Client Dashboard</h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="background: var(--white); padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border: 1px solid var(--beige-accent);">
                <h4>Active Orders</h4>
                <p style="font-size: 2rem; font-weight: 700; color: var(--primary-brown); margin: 10px 0;">02</p>
                <a href="orders.php" style="font-size: 0.9rem; color: var(--primary-brown); text-decoration: none;">View all orders &rarr;</a>
            </div>
            <div style="background: var(--white); padding: 25px; border-radius: 15px; box-shadow: var(--shadow); border: 1px solid var(--beige-accent);">
                <h4>Reward Points</h4>
                <p style="font-size: 2rem; font-weight: 700; color: #1e7e34; margin: 10px 0;">450</p>
                <p style="font-size: 0.8rem; color: var(--text-light);">You are a Gold Member</p>
            </div>
        </div>

        <h3 style="margin-top: 40px; margin-bottom: 20px;">Recent Activity</h3>
        <div style="background: var(--white); padding: 20px; border-radius: 15px; box-shadow: var(--shadow);">
            <p style="color: var(--text-light); text-align: center; padding: 20px;">No recent activity to show.</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
