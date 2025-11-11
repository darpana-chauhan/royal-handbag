<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Number of rows per page
$rows_per_page = 7;

// Get current page number from URL, default is 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the offset for the query
$offset = ($page - 1) * $rows_per_page;

// Get total number of orders
$total_orders_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders");
$total_orders_row = mysqli_fetch_assoc($total_orders_result);
$total_orders = $total_orders_row['total'];

// Calculate total pages
$total_pages = ceil($total_orders / $rows_per_page);

// Fetch orders for current page with limit and offset
$order_query = "SELECT * FROM orders ORDER BY id DESC LIMIT $rows_per_page OFFSET $offset";
$order_result = mysqli_query($con, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Manage Orders | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<!-- Main Content -->
<div class="main-content" style="margin-left: 250px; padding: 40px 30px 20px;">
    <div class="container-fluid">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h3 class="fw-bold text-center text-primary mb-4">Manage Orders</h3>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Payment Method</th>
                                <th>Payment Details</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($order_result) > 0): ?>
                                <?php while($order = mysqli_fetch_assoc($order_result)) : ?>
                                    <tr>
                                        <td><?= $order['id']; ?></td>
                                        <td><?= $order['user_id']; ?></td>
                                        <td><?= htmlspecialchars($order['fullname']); ?></td>
                                        <td><?= htmlspecialchars($order['email']); ?></td>
                                        <td><?= htmlspecialchars($order['phone']); ?></td>
                                        <td><?= htmlspecialchars($order['address']); ?></td>
                                        <td><?= htmlspecialchars($order['city']); ?></td>
                                        <td><?= htmlspecialchars($order['zip']); ?></td>
                                        <td><?= htmlspecialchars($order['payment_method']); ?></td>
                                        <td><?= htmlspecialchars($order['payment_details']); ?></td>
                                        <td>₹<?= number_format($order['total_amount'], 2); ?></td>
                                        <td>
                                            <form action="update_order_status.php" method="post">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <select name="status" onchange="this.form.submit()" class="form-select">
                                                    <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                                    <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td><?= $order['created_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="13" class="text-muted">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <!-- Previous page link -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
                            </li>

                            <?php 
                            // Show page numbers (simple version: show all pages)
                            for ($i = 1; $i <= $total_pages; $i++): 
                            ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next page link -->
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
