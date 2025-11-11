<?php
session_start();
include 'header.php';
include 'sidebar.php';
include 'connection.php';

$success = '';
$error = '';

// Add Category
if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    if (!empty($name)) {
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        if (mysqli_query($con, $sql)) {
            $success = "Category added successfully!";
        } else {
            $error = "Error: " . mysqli_error($con);
        }
    } else {
        $error = "Please enter a category name.";
    }
}

// Update Category
if (isset($_POST['update_category'])) {
    $id = (int) $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    if (!empty($name)) {
        $sql = "UPDATE categories SET name='$name' WHERE id=$id";
        if (mysqli_query($con, $sql)) {
            $success = "Category updated successfully!";
        } else {
            $error = "Update failed: " . mysqli_error($con);
        }
    } else {
        $error = "Please enter a category name.";
    }
}

// Delete Category
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        $success = "Category deleted successfully!";
    } else {
        $error = "Delete failed: " . mysqli_error($con);
    }
}

// Edit Check
$edit = false;
$edit_category = ['id' => '', 'name' => ''];
if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    $result = mysqli_query($con, "SELECT * FROM categories WHERE id=$edit_id");
    if (mysqli_num_rows($result) > 0) {
        $edit_category = mysqli_fetch_assoc($result);
        $edit = true;
    }
}

// Fetch Categories Again
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/images/logos/favicon-128.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0; overflow-x: hidden;">

<div class="page-content d-flex justify-content-center align-items-center" style="background-color: #f4f5f7; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body px-4 py-5">

                        <h3 class="fw-semibold text-center mb-4 text-dark">Manage Categories</h3>

                        <?php if ($success): ?>
                            <div class="alert alert-success text-center"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger text-center"><?= $error ?></div>
                        <?php endif; ?>

                        <!-- Add or Update Form -->
                        <form method="post" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="name" class="form-control rounded-start-pill" placeholder="Enter Category Name" required value="<?= htmlspecialchars($edit_category['name']) ?>">
                                <?php if ($edit): ?>
                                    <input type="hidden" name="id" value="<?= $edit_category['id'] ?>">
                                    <button class="btn btn-success rounded-end-pill px-4" name="update_category">Update</button>
                                <?php else: ?>
                                    <button class="btn btn-primary rounded-end-pill px-4" name="add_category">Add</button>
                                <?php endif; ?>
                            </div>
                        </form>

                        <hr class="my-4">

                        <h5 class="fw-bold text-dark mb-3">All Categories</h5>
                        <ul class="list-group list-group-flush">
                            <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($cat['name']) ?>
                                    <div class="d-flex gap-2">
                                        <a href="?edit=<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?delete=<?= $cat['id'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this category?');">
                                            Delete
                                        </a>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
