<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

ob_start();
?>
<section class="bg-image text-white text-center py-5" style="background-image: url('/sport-shoes/assets/images/hero-banner.avif'); background-size: cover; height: 40vh;">
  <div class="mask d-flex justify-content-center align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.6);">
    <div class="container">
      <h1 class="display-4 fw-bold">About Us</h1>
      <p class="lead">Your Ultimate Destination for Soccer Shoes</p>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Our Story</h2>
    <div class="row align-items-center">
      <div class="col-md-6">
        <p>Since our founding, we’ve been committed to bringing top-quality soccer footwear to athletes and enthusiasts of all levels. Our journey began with a passion for soccer and a mission to make the best shoes accessible to everyone. Today, we're proud to be a trusted source for high-performance soccer shoes.</p>
      </div>
      <div class="col-md-6">
        <img src="/sport-shoes/assets/images/about-hero.jpg" class="about-hero" alt="Our Story" style="width: 100%; height: 300px; background-size: cover;">
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Our Values</h2>
    <div class="row">
      <div class="col-md-4 mb-4 text-center">
        <div class="p-4 border rounded">
          <h5>Quality</h5>
          <p>We offer only the best products, ensuring durability and comfort for every player.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4 text-center">
        <div class="p-4 border rounded">
          <h5>Innovation</h5>
          <p>Our designs incorporate the latest technology to enhance your game experience.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4 text-center">
        <div class="p-4 border rounded">
          <h5>Customer Focus</h5>
          <p>We prioritize your needs, offering a seamless shopping experience and top-notch support.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Our Mission</h2>
    <p class="text-center mb-5">Our mission is to empower soccer players to reach their full potential by providing top-quality shoes that support their journey on and off the field.</p>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <img src="/sport-shoes/assets/images/hc.jpg" alt="Quality Icon" class="mb-3" style="height: 50px;">
        <h6>High Quality Products</h6>
      </div>
      <div class="col-md-4 mb-4">
        <img src="/sport-shoes/assets/images/material-improvement.png" alt="Sustainability Icon" class="mb-3" style="height: 50px;">
        <h6>Commitment to Sustainability</h6>
      </div>
      <div class="col-md-4 mb-4">
        <img src="/sport-shoes/assets/images/mission.png" alt="Customer Satisfaction Icon" class="mb-3" style="height: 50px;">
        <h6>Excellence in Service</h6>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">Why Choose Us?</h2>
    <div class="row">
      <div class="col-md-4 text-center mb-4">
        <img src="/sport-shoes/assets/images/wide-selection.jpg" class="img-fluid rounded-circle mb-3" alt="Wide Selection" style="height:100px;">
        <h5>Wide Selection</h5>
        <p>We provide a diverse range of brands and models to meet every player's needs.</p>
      </div>
      <div class="col-md-4 text-center mb-4">
        <img src="/sport-shoes/assets/images/affordable-prices.png" class="img-fluid rounded-circle mb-3" alt="Affordable Prices" style="height:100px;">
        <h5>Affordable Prices</h5>
        <p>Our competitive pricing ensures you get the best value for your investment.</p>
      </div>
      <div class="col-md-4 text-center mb-4">
        <img src="/sport-shoes/assets/images/trusted-partners.jpg" class="img-fluid rounded-circle mb-3" alt="Trusted Partners" style="height:100px;">
        <h5>Trusted Partners</h5>
        <p>We work with reputable brands to bring you the highest quality products.</p>
      </div>
    </div>
  </div>
</section>
<?php
$usercontent = ob_get_clean();

include __DIR__ . '/userlayout.php';