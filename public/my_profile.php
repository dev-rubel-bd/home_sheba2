<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}

include("../includes/header4.php");
// Include the database connection
require_once '../includes/db.php';

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user information from the database
$query = "SELECT name, username, email, profile_picture, user_role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $username = $user['username'];
    $email = $user['email'];
    $profile_picture = $user['profile_picture']; // Assuming this stores the file path or URL
    $user_role = $user['user_role'];
} else {
    echo "User not found.";
    exit();
}


// Close database connection
$stmt->close();
$conn->close();
?>

<link rel="stylesheet" href="../css/other_style.css"> 



<div class="mYprofile-container">

    <div class="myprofile_flex">
        <h1>My Profile</h1>
        <div class="myprofile_close">
            <a href="<?php echo ($user_role === 'service_provider') ? '../service_provider/dashboard.php' : '../service_holder/dashboard.php'; ?>" class="myprofile_close-btn">
                Close
            </a>
        </div>
    </div>

    <div class="mYprofile-card">
        <div class="mYprofile-picture">
            <img src="<?php echo htmlspecialchars($profile_picture ?: 'default-profile.png'); ?>" alt="Profile Picture">
        </div>
        <div class="mYprofile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $user_role))); ?></p>
        </div>
    </div>
    <div class="mYprofile-actions">
        <a href="edit_profile.php">Edit Profile</a>
        <a href="javascript:void(0)" id="logout-button">Logout</a>
    </div>
</div>


<!-- Logout Modal -->
<div id="logout-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Are you sure you want to log out?</h2>
        <div class="mYprofile-actions">
            <a href="my_profile.php">Cancel</a>
            <a href="login.php" id="logout-button">Logout</a>
        </div>
    </div>
</div>

<script src="../js/modal.js"></script>



