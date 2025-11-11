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

// Calculate offset for query
$offset = ($page - 1) * $rows_per_page;

// Get total number of users
$total_users_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM registration");
$total_users_row = mysqli_fetch_assoc($total_users_result);
$total_users = $total_users_row['total'];

// Calculate total pages
$total_pages = ceil($total_users / $rows_per_page);

// Fetch users for current page
$qry = "SELECT * FROM registration ORDER BY id DESC LIMIT $rows_per_page OFFSET $offset";
$result = mysqli_query($con, $qry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>All Users | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">

    <!-- Bootstrap & Bootstrap Icons -->
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
                        <h3 class="fw-bold text-center text-primary mb-4">All Users</h3>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-bordered text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Pincode</th>
                                        <th>Profile</th>
                                        <th style="min-width: 120px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['email']); ?></td>
                                                <td><?= htmlspecialchars($row['phone_no']); ?></td>
                                                <td><?= htmlspecialchars($row['country']); ?></td>
                                                <td><?= htmlspecialchars($row['state']); ?></td>
                                                <td><?= htmlspecialchars($row['city']); ?></td>
                                                <td><?= htmlspecialchars($row['code']); ?></td>
                                                <td>   
                                                    <img src="../<?= htmlspecialchars($row['profile_img']); ?>" alt="Profile" width="50" height="50" class="rounded-circle object-fit-cover">
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-outline-info btn-sm" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="delete_user.php?id=<?= $row['id']; ?>" class="btn btn-outline-danger btn-sm" title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this user?');">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">No users found.</td>
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
                </div> <!-- /card -->
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
