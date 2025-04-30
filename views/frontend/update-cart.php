<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';

// Check if the product_id and quantity are set
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
               
                if ($newQuantity > 0) {
                    $item['quantity'] = $newQuantity;
                } else {
                    
                }
                break;
            }
        }
    }

    // Redirect back to the cart
    header('Location: /sport-shoes/views/frontend/cart.php');
    exit();
}
?>