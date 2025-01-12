<?php
session_start();
include '../includes/header4.php';
require_once '../includes/db.php';

$errors = [];
$email = isset($_GET['email']) ? trim($_GET['email']) : ''; // Get email from URL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = trim($_POST['otp']);

    if (empty($email)) {
        $errors[] = "Email is missing. Please try again.";
    } elseif (empty($otp)) {
        $errors[] = "OTP is required.";
    } else {
        // Fetch OTP details from the database
        $query = "SELECT ev.user_id, ev.otp_code, ev.otp_expiry, ev.is_verified, u.is_verified AS user_verified
                  FROM email_verifications ev
                  JOIN users u ON ev.user_id = u.id
                  WHERE u.email = ? AND ev.is_verified = 0";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $db_otp = $row['otp_code'];
            $otp_expiry = $row['otp_expiry'];

            if ($row['user_verified']) {
                $errors[] = "This account is already verified.";
            } elseif ($otp !== $db_otp) {
                $errors[] = "Invalid OTP. Please try again.";
            } elseif (strtotime($otp_expiry) < time()) {
                $errors[] = "OTP has expired. Please request a new one.";
            } else {
                // Mark OTP as verified
                $update_otp_query = "UPDATE email_verifications SET is_verified = 1 WHERE user_id = ?";
                $stmt = $conn->prepare($update_otp_query);
                $stmt->bind_param("i", $row['user_id']);
                $stmt->execute();

                // Update user's verification status
                $update_user_query = "UPDATE users SET is_verified = 1 WHERE id = ?";
                $stmt = $conn->prepare($update_user_query);
                $stmt->bind_param("i", $row['user_id']);
                $stmt->execute();

                // Redirect to dashboard
                header("Location: login.php");
                exit();
            }
        } else {
            $errors[] = "Invalid or expired OTP.";
        }
    }
}

$conn->close();
?>

<link rel="stylesheet" href="../css/form.css">
<container>
<div style="height: 300px; width: auto;" class="hero">
  <form class="form" action="verify_otp.php?email=<?php echo urlencode($email); ?>" method="post">
    <h2>Verify OTP</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-group">
      <label for="otp">Enter OTP:</label>
      <input type="text" id="otp" name="otp" placeholder="Enter OTP">
    </div>

    <div class="form-group">
      <button type="submit" id="verify-button">Verify OTP</button>
    </div>
  </form>
</div>
</container>
