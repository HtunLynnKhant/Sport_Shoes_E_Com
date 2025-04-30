<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/sport-shoes/assets/images/logo.jpg" type="image/x-icon">
    <title>Admin - <?php echo $title ?? 'Default Title'; ?></title>

    <!-- Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS Links -->
    <link rel="stylesheet" href="/sport-shoes/assets/css/admin/style.css">
    <link rel="stylesheet" href="/sport-shoes/assets/css/admin/styles.min.css">
</head>
<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
        
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a href="" class="text-nowrap logo-img">
                        <img src="/sport-shoes/assets/images/logo.jpg" alt="logo" width="100" height="40">
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </div>
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/sport-shoes/views/admin/dashboard.php" aria-expanded="false">
                                <span>
                                    <i class="bi bi-speedometer2"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <span class="hide-menu">COMPONENTS</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/sport-shoes/views/admin/category/category.php" aria-expanded="false">
                                <span>
                                    <i class="bi bi-columns-gap"></i>
                                </span>
                                <span class="hide-menu">Categories</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/sport-shoes/views/admin/product/product.php" aria-expanded="false">
                                <span>
                                    <i class="bi bi-columns-gap"></i>
                                </span>
                                <span class="hide-menu">Products</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/sport-shoes/views/admin/order/order.php" aria-expanded="false">
                                <span>
                                    <i class="bi bi-columns-gap"></i>
                                </span>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/sport-shoes/views/admin/contact/feedback.php" aria-expanded="false">
                                <span>
                                    <i class="bi bi-columns-gap"></i>
                                </span>
                                <span class="hide-menu">Feedback</span>
                            </a>
                        </li>
                    </ul>
                    <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
                        <div class="d-flex">
                            <a href="/sport-shoes/logout.php" class="btn btn-primary fw-semibold"><i class="bi bi-box-arrow-right"></i> Log out</a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <header class="app-header bg-white">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="bi bi-text-wrap"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="bi bi-bell"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover">
                                <?= htmlspecialchars($_SESSION['user']['username']); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Header End -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h4 class="page-title"><?php echo $title; ?></h4>
                        <h6><a href="/sport-shoes/views/admin/dashboard.php"><i class="bi bi-house"></i> Dashboard</a> <?php echo $nav; ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title px-4 mt-4">
                        <?php echo $button; ?>
                    </div>
                    <div class="card-body">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Links -->
    <script src="/sport-shoes/assets/js/admin/jquery.min.js"></script>
    <script src="/sport-shoes/assets/js/admin/bootstrap.bundle.min.js"></script>
    <script src="/sport-shoes/assets/js/admin/sidebarmenu.js"></script>
    <script src="/sport-shoes/assets/js/admin/app.min.js"></script>
</body>
</html>