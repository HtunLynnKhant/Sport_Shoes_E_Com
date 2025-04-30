<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: /sport-shoes/views/admin/product/product.php");
    exit;
}

$productId = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindParam(':id', $productId);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: /sport-shoes/views/admin/product/product.php");
    exit;
}


$title = "Edit Product";
$nav = " > Edit Product";

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['description'], $_POST['prices'], $_POST['quantity'], $_POST['stock'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['prices'];
    $quantity = $_POST['quantity']; 
    $stock = $_POST['stock'];

    $imageUrl = $product['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $image = $_FILES['image'];
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/assets/images/products/';
        $imagePath = $targetDir . basename($image['name']);

        
        if ($image['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($image['tmp_name'], $imagePath);
            $imageUrl = '/sport-shoes/assets/images/products/' . basename($image['name']);
        } else {
            $error_message = "Image upload failed.";
        }
    }

    $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, image = :image, quantity = :quantity, stock = :stock WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $imageUrl);
    $stmt->bindParam(':quantity', $quantity); 
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':id', $productId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<p class='alert alert-success'>Product updated successfully!</p>";
        header("Location: /sport-shoes/views/admin/product/product.php");
        exit;
    } else {
        $error_message = "Failed to update product.";
    }
}

// Page content
$content = "
<div class='container'>
    <h1>Edit Product</h1>
    <form action='' method='POST' enctype='multipart/form-data'>
        " . (isset($error_message) ? "<p class='alert alert-danger'>$error_message</p>" : "") . "
        
        <div class='mb-3'>
            <label for='name' class='form-label'>Name</label>
            <input type='text' class='form-control' id='name' name='name' value='{$product['name']}' required>
        </div>

        <div class='mb-3'>
            <label for='description' class='form-label'>Description</label>
            <textarea class='form-control' id='description' name='description' required>{$product['description']}</textarea>
        </div>

        <div class='mb-3'>
            <label for='price' class='form-label'>Price</label>
            <input type='number' class='form-control' id='price' name='prices' value='{$product['price']}' required>
        </div>

        <div class='mb-3'>
            <label for='quantity' class='form-label'>Quantity</label>
            <input type='number' class='form-control' id='quantity' name='quantity' value='{$product['quantity']}' required min='0'>
        </div>

        <div class='mb-3'>
            <label for='stock' class='form-label'>Stock</label>
            <input type='number' class='form-control' id='stock' name='stock' value='{$product['stock']}' required min='0'>
        </div>

        <div class='mb-3'>
            <label for='image' class='form-label'>Image</label>
            <input type='file' class='form-control' id='image' name='image'>
            <img src='{$product['image']}' alt='Current Image' style='width: 100px; height: auto;'>
        </div>

        <button type='submit' class='btn btn-primary'>Update Product</button>
    </form>
</div>
";

// Include the layout template
include __DIR__ . '/../layout.php';
?>