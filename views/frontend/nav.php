<?php
session_start();

// Define the current page by checking the current script name
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- Navbar with conditional display based on login status -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="/sport-shoes/assets/images/logo.jpg" alt="logo" width="100" height="40"></a>
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="/sport-shoes/index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'shop.php') ? 'active' : ''; ?>" href="/sport-shoes/views/frontend/shop.php">Shop</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'about.php') ? 'active' : ''; ?>" href="/sport-shoes/views/frontend/about.php">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : ''; ?>" href="/sport-shoes/views/frontend/contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-3">
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'cart.php') ? 'active' : ''; ?>" href="/sport-shoes/views/frontend/cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>)</a>
        </li>
      </ul>

      <?php if (isset($_SESSION['user'])): ?>
        <ul class="navbar-nav ms-3">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($_SESSION['user']['username']); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              
              <li><a class="dropdown-item" href="/sport-shoes/logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      <?php else: ?>
        <ul class="navbar-nav ms-3">
          <li class="nav-item"><a class="btn btn-outline-primary me-2" href="/sport-shoes/login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary" href="/sport-shoes/register.php">Register</a></li>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>