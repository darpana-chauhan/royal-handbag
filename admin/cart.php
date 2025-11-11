<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Rows per page
$rows_per_page = 7;

// Current page number from URL parameter, default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset for SQL query
$offset = ($page - 1) * $rows_per_page;

// Get total number of cart items
$total_items_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM cart");
$total_items_row = mysqli_fetch_assoc($total_items_result);
$total_items = $total_items_row['total'];

// Calculate total pages
$total_pages = ceil($total_items / $rows_per_page);

// Fetch cart items for current page with JOINs
$cart_query = "SELECT c.*, r.name AS user_name, p.name AS product_name FROM cart c
               JOIN registration r ON c.user_id = r.id
               JOIN products p ON c.product_id = p.id
               ORDER BY c.id DESC
               LIMIT $rows_per_page OFFSET $offset";
$cart_result = mysqli_query($con, $cart_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>All Cart Items | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="main-content" style="margin-left: 250px; padding: 40px 30px 20px;">
    <div class="container-fluid">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h3 class="fw-bold text-center text-primary mb-4">All Cart Items</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Cart ID</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Added Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($cart_result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($cart_result)) : ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= htmlspecialchars($row['user_name']); ?></td>
                                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                                        <td><?= $row['quantity']; ?></td>
                                        <td><?= $row['created_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-muted">No cart items found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <!-- Previous -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
