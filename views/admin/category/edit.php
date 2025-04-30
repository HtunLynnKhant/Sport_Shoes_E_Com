<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "<p class='alert alert-danger'>No category ID provided.</p>";
    header("Location: category.php");
    exit;
}

$id = $_GET['id'];
$category = '';

try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['message'] = "<p class='alert alert-danger'>Category not found.</p>";
        header("Location: category.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['message'] = "<p class='alert alert-danger'>Error fetching category: " . $e->getMessage() . "</p>";
    header("Location: category.php");
    exit;
}

// Title of the page
$title = "Edit Category";

$nav = " > Edit Category";


$button = '<a href="/sport-shoes/views/admin/category/category.php" class="btn btn-sm btn-primary">Back</a>';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $categoryName = $_POST['name'];
    try {
        $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->bindParam(':name', $categoryName);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = "<p class='alert alert-success'>Category updated successfully!</p>";
            header("Location: category.php");
            exit;
        } else {
            $_SESSION['message'] = "<p class='alert alert-danger'>Failed to update category.</p>";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "<p class='alert alert-danger'>Error updating category: " . $e->getMessage() . "</p>";
    }
}

// Content of the dashboard
$content = '
<div class="container-fluid">
    ' . ($_SESSION['message'] ?? '') . '
    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="' . htmlspecialchars($category['name']) . '" required />
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
';

// Include the layout template
include __DIR__ . '/../layout.php';
?>