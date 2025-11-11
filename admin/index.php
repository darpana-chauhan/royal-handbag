<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}

include 'connection.php';
include 'header.php';
include 'sidebar.php';

// Admin Name from Session
$adminName = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Royal Handbag Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">

    <!-- Styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />

    <!-- External Icons -->
    <link href="https://cdn.jsdelivr.net/npm/iconoir@6.7.0/css/iconoir.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0; overflow-x: hidden;">

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-body py-4 px-5">
                            <h3 class="text-dark fw-bold mb-2">Welcome, Admin <?= htmlspecialchars($adminName); ?> 👋</h3>
                            <p class="text-muted mb-0">You are logged in to the <strong>Royal Handbag Admin Panel</strong>.</p>
                        </div>
                    </div>
                </div>

                <!-- You can add stats cards, charts, or quick links below -->
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-bag-fill text-primary fs-2 mb-2"></i>
                            <h5 class="fw-semibold">Manage Products</h5>
                            <a href="products.php" class="btn btn-outline-primary mt-2 btn-sm">Go to Products</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-people-fill text-success fs-2 mb-2"></i>
                            <h5 class="fw-semibold">Manage Users</h5>
                            <a href="user.php" class="btn btn-outline-success mt-2 btn-sm">Go to Users</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-cart-check-fill text-danger fs-2 mb-2"></i>
                            <h5 class="fw-semibold">Manage Orders</h5>
                            <a href="orders.php" class="btn btn-outline-danger mt-2 btn-sm">Go to Orders</a>
                        </div>
                    </div>
                </div>

                <!-- Add more dashboard widgets as needed -->
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
