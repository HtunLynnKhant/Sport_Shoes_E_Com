<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

if (!isset($_GET['id'])) {
    header("Location: /sport-shoes/views/admin/product/product.php");
    exit;
}

$productId = $_GET['id'];

$stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id");
$stmt->bindParam(':id', $productId);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    $_SESSION['message'] = "<p class='alert alert-danger'>Product not found.</p>";
    header("Location: /sport-shoes/views/admin/product/product.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
$stmt->bindParam(':id', $productId);

if ($stmt->execute()) {
    if (!empty($product['image'])) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); 
        }
    }
    $_SESSION['message'] = "<p class='alert alert-success'>Product deleted successfully!</p>";
} else {
    $_SESSION['message'] = "<p class='alert alert-danger'>Failed to delete product.</p>";
}

// Redirect back to the product listing page
header("Location: product.php");
exit;
?>