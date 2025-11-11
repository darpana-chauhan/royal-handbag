<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Rows per page
$rows_per_page = 10;

// Current page number from URL parameter, default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $rows_per_page;

// Get total products count
$total_products_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM products");
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];

// Calculate total pages
$total_pages = ceil($total_products / $rows_per_page);

// Fetch products with limit and offset
$products_query = "
    SELECT p.*, c.name AS category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.id DESC 
    LIMIT $rows_per_page OFFSET $offset
";
$products = mysqli_query($con, $products_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>All Products | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<!-- Main Content -->
<div class="main-content" style="margin-left: 250px; padding: 40px 30px 20px;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xxl-12 col-xl-12 col-lg-12">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body px-4 py-4">
                        <h3 class="fw-bold text-center text-primary mb-4">All Products</h3>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price (₹)</th>
                                        <th>Stock</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Features</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($products) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($products)) : ?>
                                            <tr>
                                                <td>
                                                    <img src="uploads/<?= htmlspecialchars($row['image1']) ?>" alt="product" class="img-thumbnail" width="60" height="60" style="object-fit: cover;" />
                                                </td>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td>₹<?= number_format($row['price'], 2) ?></td>
                                                <td><?= $row['stock'] ?></td>
                                                <td><?= htmlspecialchars($row['category_name']) ?></td>
                                                <td class="text-start"><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                                                <td>
                                                    <?php if ($row['is_featured'] == 1): ?>
                                                        <span class="badge bg-success">Yes</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">No</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-outline-info btn-sm" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this product?')">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No products found.</td>
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
                </div> <!-- /card -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
