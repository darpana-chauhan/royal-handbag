<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Fetch admin users
$query = "SELECT * FROM admin_login";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin List | Admin Panel</title>
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
                <h3 class="fw-bold text-center text-primary mb-4">All Admin Users</h3>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while($admin = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td><?= $admin['id']; ?></td>
                                        <td><?= htmlspecialchars($admin['name']); ?></td>
                                        <td><?= htmlspecialchars($admin['email']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-muted">No admin users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
