<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

// Title of the page
$title = "Orders";

// Navigation breadcrumbs
$nav = " > Orders";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    $updateStmt = $pdo->prepare("UPDATE orders SET status = 'approved' WHERE id = :order_id");
    if ($updateStmt->execute([':order_id' => $orderId])) {
        $message = "Order ID: " . htmlspecialchars($orderId) . " has been approved successfully.";
        unset($_SESSION['cart']);
    } else {
        $message = "Failed to approve order ID: " . htmlspecialchars($orderId);
    }
}


$stmt = $pdo->prepare("SELECT * FROM orders WHERE status = 'pending'");
$stmt->execute();
$pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Content of the dashboard
$content = '
<div class="container-fluid">
    <h2 class="mt-4">Pending Orders</h2>
    ' . ($message ? '<div class="alert alert-info">' . htmlspecialchars($message) . '</div>' : '') . '
    <div class="row">
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="text-bold">
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Product ID</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">';


if ($pendingOrders) {
    foreach ($pendingOrders as $order) {
        $content .= '
            <tr>
                <td>' . htmlspecialchars($order['id']) . '</td>
                <td>' . htmlspecialchars($order['user_name']) . '</td>
                <td>' . htmlspecialchars($order['product_id']) . '</td>
                <td>' . htmlspecialchars($order['quantity']) . '</td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="order_id" value="' . htmlspecialchars($order['id']) . '" />
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </td>
            </tr>';
    }
} else {
    $content .= '<tr><td colspan="5">No pending orders found.</td></tr>';
}

$content .= '
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
';

// Include the layout template
include __DIR__ . '/../layout.php';