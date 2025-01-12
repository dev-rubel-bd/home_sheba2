<?php
session_start();

include '../includes/header4.php';
require_once '../includes/db.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
require_once '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input validation
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);
    $user_role = trim($_POST['user_role']);
    $terms = isset($_POST['terms']);

    if (empty($username)) $errors[] = "Username is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($user_role)) $errors[] = "Please select a role.";
    if (!$terms) $errors[] = "You must agree to the Terms & Conditions.";

    // Check if email or username already exists
    $query = "SELECT id FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "This email or username is already taken.";
    $stmt->close();

    if (empty($errors)) {
        // Hash password and insert user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (name, username, email, password, user_role, is_verified) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $username, $username, $email, $hashed_password, $user_role);

        if ($stmt->execute()) {
            $user_id = $conn->insert_id;

            // Store user ID in session
            $_SESSION['user_id'] = $user_id;

            // Generate OTP and insert into database
            $otp = rand(100000, 999999);
            $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $insert_otp_query = "INSERT INTO email_verifications (user_id, otp_code, otp_expiry, is_verified) VALUES (?, ?, ?, 0)";
            $stmt_otp = $conn->prepare($insert_otp_query);
            $stmt_otp->bind_param("iss", $user_id, $otp, $otp_expiry);
            $stmt_otp->execute();

            // Send OTP via email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rubel.pust53@gmail.com'; // Replace with your email
                $mail->Password = 'lggxesumzymiuwwn'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('rubel.pust53@gmail.com', 'Home Sheba');
                $mail->addAddress($email);

                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP code is: $otp\nIt will expire in 10 minutes.";

                if ($mail->send()) {
                    header("Location: verify_otp.php?email=" . urlencode($email));
                    exit();
                } else {
                    $errors[] = "Failed to send OTP.";
                }
            } catch (Exception $e) {
                $errors[] = "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}

$conn->close();
?>

<link rel="stylesheet" href="../css/form.css">
<container>
<div class="hero">
  <form class="form" action="signup.php" method="post">
    <h2>Sign Up</h2>

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
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter username">
    </div>

    <div class="form-group">
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="Enter email address">
    </div>

    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter password">
    </div>

    <div class="form-group">
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password">
    </div>

    <div class="form-group">
      <label for="user-role">Sign Up As:</label>
      <select id="user-role" name="user_role" required>
        <option value="">-- Select Role --</option>
        <option value="service_provider">Service Provider</option>
        <option value="service_holder">Service Holder</option>
      </select>
    </div>

    <div class="form-group">
      <input type="checkbox" id="terms" name="terms" required>
      <label for="terms">I agree to the Terms & Conditions</label>
    </div>

    <div class="form-group">
      <button type="submit" id="signup-button">Sign Up</button>
    </div>
    <a href="login.php">Log In</a>
  </form>
</div>
</container>
