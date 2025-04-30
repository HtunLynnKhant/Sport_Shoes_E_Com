<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php'; 

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];
    $desiredQuantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; 


    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = :product_id");
    $stmt->execute([':product_id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $availableStock = $product['stock'];

        if ($desiredQuantity > $availableStock) {
            $_SESSION['error_message'] = "Cannot add $desiredQuantity of $productName to the cart. Only $availableStock available.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Check if the cart exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                
                $newQuantity = $item['quantity'] + $desiredQuantity;
                if ($newQuantity > $availableStock) {
                    $_SESSION['error_message'] = "Cannot add $desiredQuantity of $productName. Only $availableStock available.";
                } else {
                    $item['quantity'] = $newQuantity; 
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'image' => $productImage,
                'quantity' => $desiredQuantity,
            ];
        }
    } else {
        $_SESSION['error_message'] = "Product not found.";
    }

    // Redirect back to the previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>