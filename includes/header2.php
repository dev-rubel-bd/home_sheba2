
<?php
session_start();
require_once 'db.php'; // database connection file import

// default profile picture
$default_profile_picture = '../assets/default-profile.png';
$user_name = "Guest"; // Default name if not logged in

// get user id from session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // get photo and name from database
    $query = "SELECT profile_picture, name FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $profile_picture = $row['profile_picture'] ?: $default_profile_picture; // if no picture, set default
        $user_name = $row['name']; // fetch the user's name
    } else {
        $profile_picture = $default_profile_picture; // if user not found
    }

    $stmt->close();
} else {
    $profile_picture = $default_profile_picture; // if no session
}

// close database connection
$conn->close();
?>

<link rel="stylesheet" href="../css/style.css" />

<body style="padding: 10px">
  <header>
    <!-- Nav Section -->
    <nav>
      <div class="nav">
        <div class="nav-logo">
          <img src="../assets/HomePage/Logo.png" alt="Logo" />
          <ul class="left-nav">
            <li><a href="../index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="nav-service">
          <h4>Become a</h4>
          <ul>
            <a href="../service_holder/dashboard.php" class="user">Service Holder</a>
          </ul>
        </div>
        <div>
          <ul class="right-nav3">
            <!-- Profile Picture -->
            <li>
              <a href="../public/my_profile.php" class="profile-link">
                <img 
                  src="<?php echo htmlspecialchars($profile_picture) . '?t=' . time(); ?>" 
                  alt="Profile Picture" 
                  class="profile-picture" 
                  id="header-profile-picture" 
                />
              </a>
            </li>
            <!-- My Name and Profile Link -->
            <li class="right_text">
              <p class="my_name"><?php echo htmlspecialchars($user_name); ?></p>
              <a href="../public/my_profile.php" class="my-profile-link">
                My Profile
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</body>
