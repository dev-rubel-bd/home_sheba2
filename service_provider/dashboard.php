<?php
       include('../includes/header2.php');
    ?>
    <?php
require_once '../config/config.php';
?>


<?php


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'service_provider') {
    header("Location: ../public/login.php?error=unauthorized");
    exit();
}
?>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is the Service Provider Dashboard.</p>
   

