<?php
session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        // If not logged in as admin, redirect to login page or show an error
        header("Location: /sport-shoes/login.php");
        exit();
    }

    // Set session timeout (e.g., 30 minutes)
    $timeout = 1800; // 30 minutes in seconds
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
        session_unset();
        session_destroy();
        header("Location: /login.php?message=Session expired. Please log in again.");
        exit;
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity timestamp
?>