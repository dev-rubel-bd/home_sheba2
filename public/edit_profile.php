<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}

require_once '../includes/db.php';
include("../includes/header4.php");

$user_id = $_SESSION['user_id'];
$query = "SELECT name, username, email, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $name = $user['name'];
    $username = $user['username'];
    $email = $user['email'];
    $profile_picture = $user['profile_picture'];
} else {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'];
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $profile_picture_path = $profile_picture; // Default to existing picture

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
        }
        $upload_file = $upload_dir . basename($_FILES['profile_picture']['name']);

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
            $profile_picture_path = '../uploads/' . basename($_FILES['profile_picture']['name']);
        } else {
            echo "Failed to upload profile picture.";
        }
    }

    $update_query = "UPDATE users SET name = ?, username = ?, email = ?, profile_picture = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $new_name, $new_username, $new_email, $profile_picture_path, $user_id);

    if ($update_stmt->execute()) {
        header("Location: my_profile.php?success=profile_updated");
        exit();
    } else {
        echo "Failed to update profile.";
    }
}
?>


<link rel="stylesheet" href="../css/other_style.css">

<div class="profile-container">
    <h1>Edit Profile</h1>
    <form id="edit-profile-form" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            <?php if ($profile_picture): ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Current Profile Picture" class="current-profile-picture">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn">Save Changes</button>
    </form>
</div>

<script src="../js/edit_profile.js"></script>
