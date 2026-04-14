<?php
require_once 'config.php';
// Verify is user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($_SESSION['role']); ?> Dashboard - GreenBulk</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <style>
        body { display: flex; background: #f8f9fa; min-height: 100vh; margin: 0; }
        .sidebar { width: 260px; background: var(--primary-brown); color: var(--white); display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .sidebar-header { padding: 30px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu { flex: 1; padding: 20px 0; }
        .sidebar-menu a { display: block; padding: 15px 30px; color: rgba(255,255,255,0.7); text-decoration: none; transition: var(--transition); border-left: 4px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,0.1); color: var(--white); border-left-color: var(--skin-nude); }
        .sidebar-menu i { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar-footer { padding: 20px 30px; border-top: 1px solid rgba(255,255,255,0.1); }
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .stat-card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 20px; }
        .stat-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: var(--beige-accent); color: var(--primary-brown); }
        .stat-info h3 { font-size: 1.8rem; margin: 5px 0; }
        .stat-info p { color: var(--text-light); font-size: 0.9rem; margin: 0; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 30px; background: var(--white); border-radius: 10px; overflow: hidden; box-shadow: var(--shadow); }
        .data-table th, .data-table td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #eee; }
        .data-table th { background: #fafafa; font-weight: 600; color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: #e6f4ea; color: #1e7e34; }
        .badge-pending { background: #fff4e5; color: #b7791f; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo BASE_URL; ?>/index.php" style="color:var(--white); text-decoration:none; font-size:1.5rem; font-weight:700;">GreenBulk</a>
        <p style="font-size:0.75rem; color:var(--skin-nude); margin-top:5px; text-transform:uppercase;"><?php echo $_SESSION['role']; ?> Panel</p>
    </div>
    <div class="sidebar-menu">
        <a href="dashboard.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="products.php"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
        <?php if($_SESSION['role'] === 'admin'): ?>
            <a href="users.php"><i class="fas fa-users"></i> Manage Users</a>
        <?php endif; ?>
        <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
    </div>
    <div class="sidebar-footer">
        <a href="<?php echo BASE_URL; ?>/logout.php" style="color:var(--skin-nude); text-decoration:none;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h2 style="margin: 0;">Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
            <p style="color: var(--text-light); margin-top: 5px;">Here is what's happening today.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <span style="font-size: 0.9rem; color: var(--text-light);"><?php echo date('M d, Y'); ?></span>
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=E8CFC1&color=6F4E37" style="width: 45px; height: 45px; border-radius: 50%;">
        </div>
    </div>
