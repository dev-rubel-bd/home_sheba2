<?php
       include('../includes/header3.php');
    ?>
    <?php
require_once '../config/config.php';
?>


<?php
// session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'service_holder') {
    header("Location: ../public/login.php");
    exit();
}
?>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
<p>This is the Service Holder Dashboard.</p>

