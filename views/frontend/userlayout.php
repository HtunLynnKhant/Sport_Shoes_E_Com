<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/sport-shoes/assets/images/logo.jpg" type="image/x-icon">
  <title>Sport Shoes Store</title>
  <!-- MDBootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/sport-shoes/assets/css/front-end/style.css">
</head>
<body>
<style>
  .shop{
    height: 500px !important;
}
</style>
<!-- Navbar with sticky-top -->
<?php include __DIR__ . '/nav.php'; ?>

<?php echo $usercontent; ?>
<footer class="bg-primary text-white py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h5>About Us</h5>
        <p>We are dedicated to providing the best soccer shoes and gear for players of all levels. Our mission is to enhance your performance on the field.</p>
      </div>
      <div class="col-md-4 mb-3">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white">Home</a></li>
          <li><a href="#" class="text-white">Shop</a></li>
          <li><a href="#" class="text-white">About Us</a></li>
          <li><a href="#" class="text-white">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h5>Contact Us</h5>
        <p>Email: support@sportshoes.com</p>
        <p>Phone: +1 (234) 567-890</p>
        <h5>Follow Us</h5>
        <div>
          <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    <div class="text-center mt-3">
      <p class="mb-0">&copy; 2024 Sport Shoes. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- MDBootstrap JS and dependencies -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
</body>
</html>