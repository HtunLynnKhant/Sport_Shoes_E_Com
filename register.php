<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            
            $_SESSION['user'] = ['username' => $username, 'role' => 'user'];
            $_SESSION['message'] = "<p class='alert alert-success'>Registration successful! Welcome, $username.</p>";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message'] = "<p class='alert alert-danger'>Registration failed.</p>";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

ob_start();
?>

<!-- Register Form Container -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-5-strong p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">Register</h3>
    
    <!-- Display the message -->
    <?php echo $message; ?>

    <!-- Register Form -->
    <form method="POST" action="">
      <div class="form-outline mb-4">
        <input type="text" id="registerUsername" class="form-control" name="username" required />
        <label class="form-label" for="registerUsername">Username</label>
      </div>
      <div class="form-outline mb-4">
        <input type="password" id="registerPassword" class="form-control" name="password" required />
        <label class="form-label" for="registerPassword">Password</label>
      </div>
      <button type="submit" class="btn btn-primary btn-block mb-4">Sign Up</button>
      <div class="text-center">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>
</div>

<?php

$usercontent = ob_get_clean();
include __DIR__ . '/views/frontend/userlayout.php';