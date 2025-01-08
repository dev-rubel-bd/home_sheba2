<?php
       include('nav.php');
       ?>


<link rel="stylesheet" href="form.css">

       <!-- Main Section -->
    <div class="hero">
      <form class="form" id="login-form">
        <h2>Login</h2>

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
          <a href="http://localhost/Home_sheba/public/signup.php"
            >Sign Up</a
          >
          <a href="#">Forgot Password?</a>
        </div>
      </form>
    </div>


    