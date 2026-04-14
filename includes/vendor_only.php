<?php
require_once 'auth.php';

if ($_SESSION['role'] !== 'vendor') {
    header("Location: " . BASE_URL . "/index.php?error=unauthorized");
    exit();
}
?>
