<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: /sport-shoes/views/admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $_SESSION['message'] = "<p class='alert alert-danger'>Invalid password.</p>";
            }
        } else {
            $_SESSION['message'] = "<p class='alert alert-danger'>User not found.</p>";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
}

ob_start(); // Start output buffering to capture the HTML content
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card shadow-5-strong p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-4">Login</h3>

    <!-- Display session message if any -->
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Clear message after displaying
    }
    ?>

    <!-- Login Form -->
    <form action="" method="POST">
      <!-- Username input -->
      <div class="form-outline mb-4">
        <input type="text" id="username" class="form-control" name="username" required />
        <label class="form-label" for="username">Username</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="password" class="form-control" name="password" required />
        <label class="form-label" for="password">Password</label>
      </div>

      <!-- Checkbox for Remember Me -->
      <div class="form-check d-flex justify-content-start mb-4">
        <input class="form-check-input me-2" type="checkbox" value="" id="rememberMe" />
        <label class="form-check-label" for="rememberMe">
          Remember me
        </label>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>

      <!-- Register Link -->
      <div class="text-center">
        <p>Not a member? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>
</div>

<?php
$usercontent = ob_get_clean(); // Get the buffered content and store it in $usercontent
include __DIR__ . '/views/frontend/userlayout.php';