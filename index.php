<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Home Sheba</title>
</head>
<body>

<container>
<header>
  <!-- Nav Section -->
  <nav>
        <div class="nav">
          <div class="nav-logo">
            <img src="assets/HomePage/Logo.png" alt="Logo" />
            <ul class="left-nav">
              <li>
                <a href="index.php"
                  >Home</a
                >
              </li>
              <li><a href="">About</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
          <div class="nav-service">
            <h4>Become a</h4>
            <ul>
              <a
                href="service_provider/dashboard.php"
                class="user"
                >Service Provider</a
              >
              <a
                href="service_holder/dashboard.php"
                class="user"
                >Service Holder</a
              >
            </ul>
          </div>
          <div>
            <ul class="right-nav">
              <a
                href="public/login.php"
                class="button"
                >Log In</a
              >
              <a
                href="public/signup.php"
                class="button"
                >Join</a
              >
            </ul>
          </div>
        </div>
      </nav>
</header>
  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-all-img">
      <img style="transform: rotate(-25deg)" class="hero-img" src="assets/HomePage/cleaner.jpg" alt="Cleaner" />
      <img style="transform: rotate(5deg)" class="hero-img" src="assets/HomePage/barber.jpg" alt="Barber" />
      <img style="transform: rotate(25deg)" class="hero-img" src="assets/HomePage/electric.jpg" alt="Electrician" />
      <img style="transform: skewY(20deg)" class="hero-img" src="assets/HomePage/plumbing.jpg" alt="Plumbing" />
    </div>
    <div class="hero-element">
      <h2>Find Home <span>Service/Repair</span> Near You</h2>
      <input type="text" class="search-input" placeholder="Search" />
      <button class="search-button">Search</button>
    </div>
  </div>

  <hr />

  <!-- Service Categories Section -->
  <div class="service-categories">
    <h3>Our Services</h3>
    <div class="categories">
      <div class="category">
        <img src="assets/HomePage/cleaner2.jpg" alt="Cleaning" />
        <p>Cleaning</p>
      </div>
      <div class="category">
        <img src="assets/HomePage/plumbing.jpg" alt="Plumbing" />
        <p>Plumbing</p>
      </div>
      <div class="category">
        <img src="assets/HomePage/elecric2.jpg" alt="Electrician" />
        <p>Electrician</p>
      </div>
      <div class="category">
        <img src="assets/HomePage/painter2.jpg" alt="Repair" />
        <p>Repair</p>
      </div>
      <div class="category">
        <img src="assets/HomePage/painter2.jpg" alt="Repair" />
        <p>Repair</p>
      </div>
      <div class="category">
        <img src="assets/HomePage/painter2.jpg" alt="Repair" />
        <p>Repair</p>
      </div>
    </div>
  </div>

  <!-- Testimonials Section -->
  <h3 class="testimonials_header">What Our Users Say</h3>
  <div class="testimonials">
    <div class="testimonial">
      <p>"Home Sheba helped me find reliable service providers quickly and easily!"</p>
      <h5>- John Doe, Service Holder</h5>
    </div>
    <div class="testimonial">
      <p>"As a service provider, I love how easy it is to connect with clients!"</p>
      <h5>- Jane Smith, Service Provider</h5>
    </div>
    <div class="testimonial">
      <p>"Home Sheba helped me find reliable service providers quickly and easily!"</p>
      <h5>- John Doe, Service Holder</h5>
    </div>
    <div class="testimonial">
      <p>"Home Sheba helped me find reliable service providers quickly and easily!"</p>
      <h5>- John Doe, Service Holder</h5>
    </div>
  </div>

  <!-- Call to Action -->
  <div class="cta">
    <h3>Ready to Get Started?</h3>
    <a href="public/signup.php" class="cta-button">Join Now</a>
  </div>

  <!-- Footer Section -->
  <footer>
    <div class="footer-content">
      <div class="link">
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="social-links">
        <p>Follow us:</p>
        <a href="#"><img src="assets/HomePage/facebook.png" alt="Facebook" /></a>
        <a href="#"><img src="assets/HomePage/twitter.png" alt="Twitter" /></a>
        <a href="#"><img src="assets/HomePage/instagram.png" alt="Instagram" /></a>
      </div>
    </div>
  </footer>
</body>
</container>
</html>
