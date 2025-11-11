<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

// Fetch all contact messages
$contact_query = "SELECT * FROM contact ORDER BY id DESC";
$contact_result = mysqli_query($con, $contact_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>All Contacts | Admin Panel</title>
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
                <h3 class="fw-bold text-center text-primary mb-4">All Contact Messages</h3>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($contact_result) > 0): ?>
                                <?php while($contact = mysqli_fetch_assoc($contact_result)) : ?>
                                    <tr>
                                        <td><?= $contact['id']; ?></td>
                                        <td><?= htmlspecialchars($contact['email']); ?></td>
                                        <td><?= nl2br(htmlspecialchars($contact['message'])); ?></td>
                                        <td><?= $contact['submitted_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-muted">No contact messages found.</td>
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
