<?php
session_start();

// Fetch profile picture from the session or use a default image
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '../assets/default-profile.png';
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
            <a href="../service_provider/dashboard.php" class="user">Service Provider</a>
          </ul>
        </div>
        <div>
          <ul class="right-nav3">
            <!-- Profile Picture -->
            <li>
              <a href="../public/my_profile.php" class="profile-link">
              <img src="<?php echo htmlspecialchars($profile_picture) . '?t=' . time(); ?>" alt="Profile Picture"class="profile-picture"/>
              </a>
            </li>
            <!-- My Profile Link -->
            <li>
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
