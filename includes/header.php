<?php
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenBulk - Premium eCommerce</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <script src="<?php echo BASE_URL; ?>/assets/js/app.js" defer></script>
</head>
<body>

<div class="loader-wrapper">
    <div class="loader"></div>
</div>

<nav class="navbar">
    <a href="<?php echo BASE_URL; ?>/index.php" class="logo">
        <span style="color:var(--skin-nude);">Green</span>Bulk
    </a>
    
    <form action="<?php echo BASE_URL; ?>/products.php" method="GET" class="search-bar">
        <input type="text" name="q" placeholder="Search supplements..." value="<?php echo $_GET['q'] ?? ''; ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    <div class="nav-icons">
        <div class="icon-item">
            <a href="<?php echo BASE_URL; ?>/cart.php" class="cart-icon">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
            </a>
        </div>
        
        <div class="user-dropdown" id="userDropdown">
            <!-- CIRCULAR PROFILE ICON - NO TEXT -->
            <button class="profile-btn" id="userBtn">
                <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-content" id="dropdownList">
                <div class="dropdown-header">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <p>Hi, <strong><?php echo $_SESSION['name'] ?? 'User'; ?></strong></p>
                    <?php else: ?>
                        <p>Welcome to GreenBulk</p>
                    <?php endif; ?>
                </div>
                <div class="dropdown-divider"></div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/<?php echo $_SESSION['role']; ?>/dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
                    <a href="<?php echo BASE_URL; ?>/profile.php"><i class="fas fa-id-card"></i> Profile</a>
                    <a href="<?php echo BASE_URL; ?>/orders.php"><i class="fas fa-history"></i> Orders</a>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo BASE_URL; ?>/logout.php" style="color: #ff4d4d;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="<?php echo BASE_URL; ?>/register.php"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main>
