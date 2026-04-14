<?php
require_once 'config.php';

// List of public pages
$public_pages = ['login.php', 'register.php', 'index.php', 'products.php', 'product-detail.php'];
$current_page = basename($_SERVER['PHP_SELF']);

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to login if not authenticated and trying to access a protected page
if (!isLoggedIn() && !in_array($current_page, $public_pages)) {
    // Check if we are in a subdirectory like /admin or /vendor
    $redirect_url = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false || strpos($_SERVER['PHP_SELF'], '/vendor/') !== false || strpos($_SERVER['PHP_SELF'], '/client/') !== false) ? '../login.php' : 'login.php';
    header("Location: " . $redirect_url);
    exit();
}
?>
