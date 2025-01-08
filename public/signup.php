    
    
    
 <?php
       include('nav.php');
       ?>


<link rel="stylesheet" href="form.css">
<!-- Main Section -->
<div style="height: 700px; width: auto;" class="hero">
  <form style="height: 600px;" class="form" action="/signup" method="post">
    <h2>Sign Up</h2>

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
    <a href="http://localhost/Home_sheba/public/login.php">Log In</a>
  </form>
</div>
