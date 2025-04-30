<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

// Title of the page
$title = "Products";
$nav = " > Products";
$button = '<a href="/sport-shoes/views/admin/product/create.php" class="btn btn-sm btn-primary">Add product</a>';

// Display any success message
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

// Retrieve products from the database
$productRows = '';
$stmt = $pdo->query("SELECT p.id, p.name, p.image, p.stock, p.quantity, p.price, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id");

while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $imagePath = '/sport-shoes/assets/images/products/' . basename($product['image']);
    $productRows .= "
        <tr>
            <td>{$product['category_name']}</td>
            <td>{$product['name']}</td>
            <td>{$product['quantity']}</td>
            <td>{$product['stock']}</td>
            <td><img src='$imagePath' alt='{$product['name']}' style='width: 100px; height: auto;'></td>
            <td>{$product['price']}</td>
            <td>
                <a href='edit.php?id={$product['id']}' class='btn btn-sm btn-warning'>Edit</a>
                <a href='delete.php?id={$product['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\'Are you sure?\')'>Delete</a>
            </td>
        </tr>
    ";
}

// Content of the dashboard
$content = "
<div class='container'>
    $message
    <div class='row justify-content-center'>
        <div class='col-12'>
            <div class='table-responsive'>
                <table class='table table-bordered table-hover table-striped'>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody id='tableBody'>
                        $productRows
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
";

// Include the layout template
include __DIR__ . '/../layout.php';
?>