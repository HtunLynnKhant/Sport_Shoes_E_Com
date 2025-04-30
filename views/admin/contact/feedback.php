<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/config/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sport-shoes/auth.php';
// Title of the page
$title = "Feedback";

// Navigation breadcrumbs
$nav = " > Feedback";


$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$categoryRows = '';
try {
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryRows .= '
            <tr>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . htmlspecialchars($row['message']) . '</td>
            </tr>
        ';
    }
} catch (PDOException $e) {
    $message = "<p class='alert alert-danger'>Error fetching categories: " . $e->getMessage() . "</p>";
}
// Content of the dashboard
$content = '
<div class="container-fluid">
' . $message . '
        <div class="row">
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="text-bold">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">email</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                            ' . $categoryRows . '
                                
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

';

// Include the layout template
include __DIR__ . '/../layout.php';