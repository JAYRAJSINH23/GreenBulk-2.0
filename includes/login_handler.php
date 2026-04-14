<?php
require_once 'config.php';

function handleLogin($email, $password, $requiredRole) {
    // Hardcoded credentials for Demo
    $demoUsers = [
        'admin@greenbulk.com' => ['pass' => 'Admin@123', 'role' => 'admin', 'id' => 1, 'name' => 'Super Admin'],
        'vendor@greenbulk.com' => ['pass' => 'Vendor@123', 'role' => 'vendor', 'id' => 2, 'name' => 'Top Vendor'],
        'client@greenbulk.com' => ['pass' => 'Client@123', 'role' => 'client', 'id' => 3, 'name' => 'John Doe']
    ];

    if (isset($demoUsers[$email]) && $demoUsers[$email]['pass'] === $password) {
        $user = $demoUsers[$email];
        if ($user['role'] === $requiredRole) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            
            // Redirect based on role
            switch ($user['role']) {
                case 'admin': header("Location: " . BASE_URL . "/admin/dashboard.php"); break;
                case 'vendor': header("Location: " . BASE_URL . "/vendor/dashboard.php"); break;
                default: header("Location: " . BASE_URL . "/index.php"); break;
            }
            exit();
        } else {
            return "Unauthorized access for this role.";
        }
    }
    return "Invalid email or password.";
}
?>
