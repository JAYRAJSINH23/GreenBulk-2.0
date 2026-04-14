<?php
require_once 'auth.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php?error=unauthorized");
    exit();
}
?>
