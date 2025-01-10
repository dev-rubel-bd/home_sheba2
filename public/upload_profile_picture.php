<?php
session_start();
require_once '../includes/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $target_dir = "../uploads/";
    $file_name = basename($_FILES['profile_picture']['name']);
    $target_file = $target_dir . $file_name;

    // Validate file type and size
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif']) && $_FILES['profile_picture']['size'] < 5000000) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // Update the database
            $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $target_file, $user_id);
            if ($stmt->execute()) {
                $_SESSION['profile_picture'] = $target_file;
                echo json_encode(['success' => true, 'new_profile_picture_url' => $target_file]);
                exit();
            } else {
                echo json_encode(['error' => 'Database update failed.']);
                exit();
            }
        } else {
            echo json_encode(['error' => 'Failed to upload file.']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Invalid file type or size.']);
        exit();
    }
}

echo json_encode(['error' => 'Invalid request.']);
?>
