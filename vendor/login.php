<?php
require_once '../includes/login_handler.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = handleLogin($email, $password, 'vendor');
}

require_once '../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Login - GreenBulk</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <style>
        body { background: #fdfaf8; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
    </style>
</head>
<body>

<div style="max-width: 400px; width: 90%; padding: 40px; border-radius: 15px; background: var(--white); box-shadow: var(--shadow);">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: var(--primary-brown); font-size: 1.8rem;">GreenBulk</h1>
        <p style="color: var(--text-light);">Vendor Portal</p>
    </div>
    
    <?php if($error): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9rem;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; color: var(--text-light);">Vendor Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; color: var(--text-light);">Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">Vendor Log In</button>
    </form>
    
    <div style="margin-top: 25px; text-align: center;">
        <a href="<?php echo BASE_URL; ?>/index.php" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem;"><i class="fas fa-arrow-left"></i> Back to Site</a>
    </div>
</div>

</body>
</html>
