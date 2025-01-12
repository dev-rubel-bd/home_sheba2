<?php
       include('../includes/header4.php');
       ?>

<?php
require_once '../includes/db.php'; // Include database connection

session_start(); // Start session to manage logged-in state

$errors = []; // Array to store errors

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember_me = isset($_POST['remember_me']);

    // Validate inputs
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        // Check if username exists in the database
        $query = "SELECT id, username, password, user_role FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $db_username, $db_password, $user_role);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $db_password)) {
                // Authentication successful
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['user_role'] = $user_role;

                // Remember Me functionality (optional)
                if ($remember_me) {
                    setcookie("user_id", $user_id, time() + (86400 * 30), "/"); // 30 days
                    setcookie("username", $db_username, time() + (86400 * 30), "/");
                }

                // Redirect to respective dashboard based on role
                if ($user_role === 'service_provider') {
                    header("Location: ../service_provider/dashboard.php");
                } elseif ($user_role === 'service_holder') {
                    header("Location: ../service_holder/dashboard.php");
                } else {
                    $errors[] = "Invalid user role.";
                }
                exit();
            } else {
                $errors[] = "Invalid password.";
            }
        } else {
            $errors[] = "Username not found.";
        }
        $stmt->close();
    }
}
?>



    <link rel="stylesheet" href="../css/form.css">

  <container>
  <div class="hero">
        <form class="form" id="login-form" action="login.php" method="post">
            <h2>Login</h2>

            <!-- Display Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li class="error"><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username:</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter username"
                />
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                />
            </div>

            <div class="form-group">
                <input type="checkbox" id="remember-me" name="remember_me" />
                <label for="remember-me">Remember Me</label>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>

            <div class="links">
                <a href="signup.php">Sign Up</a>
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

  </container>