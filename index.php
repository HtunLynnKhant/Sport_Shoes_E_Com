<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

// Start output buffering
ob_start();

// Fetch the latest 4 products with category names from the database
$stmt = $pdo->query("
    SELECT p.*, c.name AS category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.created_at DESC 
    LIMIT 4
");
$latestProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class='bg-image' style='background-image: url("/sport-shoes/assets/images/view-soccer-shoes.jpg"); height: 100vh;'>
  <div class='mask d-flex justify-content-center align-items-center h-100' style='background-color: rgba(0, 0, 0, 0.6);'>
    <div class='text-white text-center'>
      <h1 class='display-4 fw-bold'>Step Up Your Game</h1>
      <p class='lead'>Find the perfect pair for your sports needs</p>
      <a class='btn btn-primary btn-lg' href='/sport-shoes/views/frontend/shop.php' role='button'>Shop Now</a>
    </div>
  </div>
</section>

<section class='bg-light py-5'>
  <div class='container'>
    <h2 class='text-center mb-4'>Trusted Partners</h2>
    <div class='row'>
      <!-- Partner 1 -->
      <div class='col-md-3 col-sm-6 mb-4 text-center'>
        <img src='/sport-shoes/assets/images/nike-11.svg' alt='Partner 1' height="80"/>
      </div>
      <!-- Partner 2 -->
      <div class='col-md-3 col-sm-6 mb-4 text-center'>
        <img src='/sport-shoes/assets/images/adidas-8.svg' alt='Partner 2' height="80" />
      </div>
      <!-- Partner 3 -->
      <div class='col-md-3 col-sm-6 mb-4 text-center'>
        <img src='/sport-shoes/assets/images/puma-logo.svg' alt='Partner 3' height="80" />
      </div>
      <!-- Partner 4 -->
      <div class='col-md-3 col-sm-6 mb-4 text-center'>
        <img src='/sport-shoes/assets/images/under-armour-logo.svg' alt='Partner 4' height="80" />
      </div>
    </div>
  </div>
</section>

<section class='py-3 bg-light'>
  <div class='container'>
    <h2 class='text-center mb-4'>Latest Soccer Shoes</h2>
    <div class='row'>
      <?php foreach ($latestProducts as $product): ?>
        <div class='col-md-3 mb-4 shop'>
            <div class='card shadow-sm'>
                <img src='/sport-shoes/assets/images/products/<?php echo htmlspecialchars(basename($product['image'])); ?>' class='card-img-top shoes-img' alt='<?php echo htmlspecialchars($product['name']); ?>'>
                <div class='card-body'>
                    <h5 class='card-title'><?php echo htmlspecialchars($product['name']); ?></h5>
                    <span class="badge badge-primary"><?php echo htmlspecialchars($product['category_name']); ?></span>
                    <p class='card-text'><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class='card-text'>Price: $<?php echo htmlspecialchars($product['price']); ?></p>

                    <?php if (isset($_SESSION['user'])):?>
                        <!-- Quantity Input -->
                        <form method="POST" action="/sport-shoes/views/frontend/add-to-cart.php" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">

                            <!-- Quantity input with max set to available stock -->
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" required class="form-control" />
                            </div>

                            <button type='submit' class='btn btn-success'>Add to cart</button>
                        </form>
                    <?php else: ?>
                        <p class="text-danger">Please login to add items to your cart.</p><a class="btn btn-sm btn-primary" href="/sport-shoes/views/frontend/login.php">login</a> 
                    <?php endif; ?>
                </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="d-flex align-items-center justify-content-center">
        <a href="/sport-shoes/views/frontend/shop.php" class="btn btn-primary">Browse all</a>
    </div>
  </div>
</section>

<?php
// Get the content of the buffered output
$usercontent = ob_get_clean();

// Include the user layout
include __DIR__ . '/views/frontend/userlayout.php';
?>