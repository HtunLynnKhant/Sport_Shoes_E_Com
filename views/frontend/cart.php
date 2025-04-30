<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

$totalPrice = 0;

$cartItemsWithStock = [];
foreach ($_SESSION['cart'] as $item) {
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = :product_id");
    $stmt->execute([':product_id' => $item['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        $item['stock'] = $product['stock']; 
    }
    $cartItemsWithStock[] = $item; 
}

ob_start();
?>
<section class="py-3 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Shopping Cart</h2>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItemsWithStock as $key => $item): ?>
                <tr>
                    <td>
                        <img src='/sport-shoes/assets/images/products/<?php echo htmlspecialchars(basename($item['image'])); ?>' alt='<?php echo htmlspecialchars($item['name']); ?>' width='50' height='50'>
                        <?php echo htmlspecialchars($item['name']); ?>
                    </td>
                    <td>
                        <form method="POST" action="update-cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>" />
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" required />
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                    <td>$<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                    <td>
                        <form method="POST" action="remove-from-cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>" />
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total Price: $<?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></h3>
        <p class="alert alert-info">Please note that your order will be pending approval from the admin after checkout.</p>
        <a href="checkout.php" class="btn btn-success">Checkout</a>
        <?php else: ?>
        <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</section>

<?php
$usercontent = ob_get_clean();

include __DIR__ . '/userlayout.php';
?>