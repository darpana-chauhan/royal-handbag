<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Rows per page
$rows_per_page = 10;

// Current page from URL param, default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $rows_per_page;

// Get total feedback count
$total_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM feedbacks");
$total_row = mysqli_fetch_assoc($total_result);
$total_feedbacks = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_feedbacks / $rows_per_page);

// Fetch feedbacks with LIMIT and OFFSET with user and product names
$query = "
    SELECT f.*, r.name AS user_name, p.name AS product_name 
    FROM feedbacks f 
    JOIN registration r ON f.user_id = r.id 
    JOIN products p ON f.product_id = p.id 
    ORDER BY f.created_at DESC
    LIMIT $rows_per_page OFFSET $offset
";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Feedbacks | Admin Panel</title>
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
                <h3 class="fw-bold text-center text-primary mb-4">All Product Feedbacks</h3>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Comment</th>
                                <th>Image</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php $i = $offset + 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($row['user_name']); ?></td>
                                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                                        <td style="max-width: 300px;"><?= nl2br(htmlspecialchars($row['comment'])); ?></td>
                                        <td>
                                            <?php if (!empty($row['image'])): ?>
                                                <img src="../<?= htmlspecialchars($row['image']) ?>" alt="Feedback Image" style="max-width: 80px;" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-muted">No feedbacks found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <!-- Previous button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" tabindex="-1">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next button -->
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
