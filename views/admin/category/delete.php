<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "<p class='alert alert-success'>Category deleted successfully!</p>";
        } else {
            $_SESSION['message'] = "<p class='alert alert-danger'>Failed to delete category.</p>";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "<p class='alert alert-danger'>Error deleting category: " . $e->getMessage() . "</p>";
    }
}

// Redirect back to the category list page
header("Location: category.php");
exit;
?>