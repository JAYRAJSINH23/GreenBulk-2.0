<?php
require_once 'includes/login_handler.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = handleLogin($email, $password, 'client');
}

include 'includes/header.php';
?>

<div style="max-width: 400px; margin: 100px auto; padding: 40px; border-radius: 15px; background: var(--white); box-shadow: var(--shadow);">
    <h2 style="text-align: center; color: var(--primary-brown); margin-bottom: 30px;">Client Login</h2>
    
    <?php if($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9rem;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Email Address</label>
            <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">Sign In</button>
    </form>
    
    <div style="margin-top: 20px; text-align: center; font-size: 0.9rem;">
        Don't have an account? <a href="register.php" style="color: var(--primary-brown); text-decoration: none; font-weight: 600;">Register Now</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
