    
    
    
 <?php
       include('../includes/header.php');
       ?>

<?php
require_once '../includes/db.php';

$errors = []; // To store errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);
    $user_role = trim($_POST['user_role']);
    $terms = isset($_POST['terms']) ? true : false;

    // Validate inputs
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (empty($user_role)) $errors[] = "Please select a role.";
    if (!$terms) $errors[] = "You must agree to the Terms & Conditions.";

    // Check if email or username already exists in the database
    $query = "SELECT id FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "This email or username is already taken. Please try another.";
    }
    $stmt->close();

    // If no errors, insert the new user into the database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, email, password, user_role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $user_role);
        if ($stmt->execute()) {
            // Redirect to login page with a success message
            header("Location: login.php?signup_success=1");
            exit();
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}
?>






<link rel="stylesheet" href="../css/form.css">
<!-- Main Section -->
<container>
<div style="height: 700px; width: auto;" class="hero">
  <form style="height: 650px;" class="form" action="signup.php" method="post">
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

    <!-- User Role Selection with Dropdown -->
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