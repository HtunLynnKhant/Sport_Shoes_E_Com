<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';


$title = "Create Products";
$nav = " > Create-Products";
$button = '<a href="/sport-shoes/views/admin/product/product.php" class="btn btn-sm btn-primary">Back</a>';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['description'], $_POST['prices'], $_POST['stock'], $_FILES['image'])) {
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['prices'];
    $stock = $_POST['stock']; 

    
    $image = $_FILES['image'];
    $targetDir = '/Applications/XAMPP/xamppfiles/htdocs/sport-shoes/assets/images/products/';
    $imagePath = $targetDir . basename($image['name']);

    
    if ($image['error'] !== UPLOAD_ERR_OK) {
        switch ($image['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = "<p class='alert alert-danger'>The uploaded file is too large.</p>";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message = "<p class='alert alert-danger'>The file was only partially uploaded.</p>";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = "<p class='alert alert-danger'>No file was uploaded.</p>";
                break;
            default:
                $error_message = "<p class='alert alert-danger'>An unknown error occurred.</p>";
                break;
        }
    } else {
        
        $allowedTypes = ['image/jpg','image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowedTypes)) {
            $error_message = "<p class='alert alert-danger'>Only JPEG, PNG and GIF files are allowed.</p>";
        } else {

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                $imageUrl = '/sport-shoes/assets/images/products/' . basename($image['name']);

                $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, image, quantity) VALUES (:cat_id, :name, :description, :price, :image, :stock)");
                $stmt->bindParam(':cat_id', $cat_id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image', $imageUrl);
                $stmt->bindParam(':stock', $stock); 

                if ($stmt->execute()) {
                    $_SESSION['message'] = "<p class='alert alert-success'>Product added successfully!</p>";
                    header("Location: /sport-shoes/views/admin/product/product.php");
                    exit;
                } else {
                    $error_message = "<p class='alert alert-danger'>Failed to add product. Please try again.</p>";
                }
            } else {
                $error_message = "<p class='alert alert-danger'>Image upload failed. Error: " . print_r(error_get_last(), true) . "</p>";
            }
        }
    }
}

$categoryOptions = '';
$stmt = $pdo->query("SELECT id, name FROM categories");
while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryOptions .= "<option value='{$category['id']}'>{$category['name']}</option>";
}


$message = isset($error_message) ? $error_message : ($_SESSION['message'] ?? '');
unset($_SESSION['message']);

// Page content
$content = "
<div class='container'>
    <div class='row'>
        <div class='col-md-8'>
            <form action='' method='POST' enctype='multipart/form-data'>
                $message

                <div class='mb-3 row'>
                    <label for='cat-id' class='col-sm-2 col-form-label'>Category</label>
                    <div class='col-sm'>
                        <select class='form-select' id='cat-id' name='cat_id'>
                            $categoryOptions
                        </select>
                    </div>
                </div>

                <div class='mb-3 row'>
                    <label for='name' class='col-sm-2 col-form-label'>Name</label>
                    <div class='col-sm'>
                        <input type='text' class='form-control' id='name' name='name' placeholder='Enter Name' required />
                    </div>
                </div>

                <div class='mb-3 row'>
                    <label for='image' class='col-sm-2 col-form-label'>Image</label>
                    <div class='col-sm'>
                        <input type='file' class='form-control' id='image' name='image' required />
                    </div>
                </div>

                <div class='mb-3 row'>
                    <label for='description' class='col-sm-2 col-form-label'>Description</label>
                    <div class='col-sm'>
                        <textarea rows='3' class='form-control' id='description' name='description' placeholder='Enter Description' required></textarea>
                    </div>
                </div>

                <div class='mb-3 row'>
                    <label for='price' class='col-sm-2 col-form-label'>Price</label>
                    <div class='col-sm'>
                        <input type='number' class='form-control' id='price' name='prices' placeholder='Enter Price' required />
                    </div>
                </div>

                <div class='mb-3 row'>
                    <label for='stock' class='col-sm-2 col-form-label'>Stock</label>
                    <div class='col-sm'>
                        <input type='number' class='form-control' id='stock' name='stock' placeholder='Enter stock' min='1' required />
                    </div>
                </div>

                <div class='mb-3 d-flex justify-content-center'>
                    <button type='submit' class='btn btn-primary'>Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
";

// Include the layout template
include __DIR__ . '/../layout.php';
?>