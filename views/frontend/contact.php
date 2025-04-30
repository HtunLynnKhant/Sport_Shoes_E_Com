<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

  
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<p class='alert alert-success'>Message sent successfully!. Thank your for your Messages.</p>";
    } else {
        $_SESSION['message'] = "<p class='alert alert-danger'>Failed to send message. Please try again later.</p>";
    }
}

// Start output buffering
ob_start();
?>
<section class="bg-image text-white text-center py-5" style="background-image: url('/sport-shoes/assets/images/hero-banner.avif'); background-size: cover; height: 40vh;">
  <div class="mask d-flex justify-content-center align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.6);">
    <div class="container">
      <h1 class="display-4 fw-bold">Shop</h1>
      <p class="lead">Your Ultimate Destination for Soccer Shoes</p>
    </div>
  </div>
</section>
<section class='py-3 bg-light'>
    <div class="container mt-5">
        <h1 class="text-center">Contact Us</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="text-center">
                <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <?php if (isset($_SESSION['user'])):?>
            <button type="submit" class="btn btn-primary">Send Message</button>
            <?php else: ?>
                        <p class="text-danger">Please login to send messags!</p><a class="btn btn-sm btn-primary" href="/sport-shoes/views/frontend/login.php">login</a> 
                    <?php endif; ?>
        </form>
    </div>
</section>
<?php
$usercontent = ob_get_clean();

include __DIR__ . '/userlayout.php';