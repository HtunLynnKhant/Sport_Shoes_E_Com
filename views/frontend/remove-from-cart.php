<?php
session_start();


if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                unset($_SESSION['cart'][$key]); 
                break;
            }
        }
    }

    // Redirect back to the cart
    header('Location: /sport-shoes/views/frontend/cart.php');
    exit();
}
?>