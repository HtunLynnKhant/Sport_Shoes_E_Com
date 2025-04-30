<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page
    header('Location: /sport-shoes/login.php?message=Please log in to continue.');
    exit();
}

// Check if cart exists and is not empty
if (empty($_SESSION['cart'])) {
    header('Location: /sport-shoes/index.php');
    exit();
}

// Get order details from the session
$orderDetails = $_SESSION['cart'];
$message = ''; // Initialize message variable

try {
    // Begin a transaction
    $pdo->beginTransaction();

    $orderIds = []; 
    foreach ($orderDetails as $item) {
        // Prepare statement to insert order
        $stmt = $pdo->prepare("INSERT INTO orders (user_name, product_id, quantity, status) VALUES (:user_name, :product_id, :quantity, 'pending')");
        if (!$stmt->execute([
            ':user_name' => $_SESSION['user']['username'],
            ':product_id' => $item['id'],
            ':quantity' => $item['quantity'],
        ])) {
            throw new Exception("Failed to insert order: " . implode(", ", $stmt->errorInfo()));
        }
        $orderIds[] = $pdo->lastInsertId(); 
        $productStmt = $pdo->prepare("SELECT stock FROM products WHERE id = :product_id");
        $productStmt->execute([':product_id' => $item['id']]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product && $product['stock'] >= $item['quantity']) {
            $updateStmt = $pdo->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :product_id");
            if (!$updateStmt->execute([
                ':quantity' => $item['quantity'],
                ':product_id' => $item['id']
            ])) {
                throw new Exception("Failed to update product stock: " . implode(", ", $updateStmt->errorInfo()));
            }
        } else {
            throw new Exception("Insufficient stock for product ID: " . $item['id']);
        }
    }

    $pdo->commit();

    $message = "Thank you for your order! Your order has been placed successfully.";
    $_SESSION['order_ids'] = $orderIds; 
} catch (Exception $e) {
    $pdo->rollBack();
    $message = "Error processing your order: " . htmlspecialchars($e->getMessage());
}

ob_start(); 
?>

<!-- Display order details -->
<section class="py-3 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Checkout</h2>
        <h4>Your Order:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                    <td>$<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($message): ?>
        <p class="alert alert-success"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (isset($_SESSION['order_ids'])): ?>
            <h4 class="mt-4">Order Status:</h4>
            <ul>
                <?php foreach ($_SESSION['order_ids'] as $orderId): ?>
                    <li>Order ID: <?php echo htmlspecialchars($orderId); ?> - Status: Pending Approval</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>

<?php
$usercontent = ob_get_clean(); 

include __DIR__ . '/userlayout.php'; 
?>