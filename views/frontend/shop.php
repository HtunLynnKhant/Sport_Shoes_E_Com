<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

// for pagination
$productsPerPage = 8;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $productsPerPage;

$totalStmt = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $totalStmt->fetchColumn();
$totalPages = ceil($totalProducts / $productsPerPage);

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.created_at DESC 
    LIMIT :offset, :limit
");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);
$stmt->execute();
$latestProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
  <div class='container'>
    <div class='row'>
        
    <?php foreach ($latestProducts as $product): ?>
        <div class='col-md-3 mb-4'>
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

    <!-- Pagination controls -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center mt-4">
        <?php if ($currentPage > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?php echo $currentPage === $i ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</section>

<?php
$usercontent = ob_get_clean();

// Include the user layout
include __DIR__ . '/userlayout.php';
?>