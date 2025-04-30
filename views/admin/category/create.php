<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';

$title = "Create-Category";
$nav = " > Create-Categories";
$button = '<a href="/sport-shoes/views/admin/category/category.php" class="btn btn-sm btn-primary">Back</a>';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $categoryName = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->bindParam(':name', $categoryName);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<p class='alert alert-success'>Category added successfully!</p>";
        header("Location: category.php");
        exit();
    } else {
        $error_message = "<p class='alert alert-danger'>Failed to add category.</p>";
    }
}

$content = '
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                ' . ($error_message ?? '') . ' 
                <form method="POST" action="">
                    <div class="row">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required />
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
';

include __DIR__ . '/../layout.php';