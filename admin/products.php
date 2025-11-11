<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit;
}
include 'header.php';
include 'sidebar.php';
include 'connection.php';

$success = '';
$error = '';
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY name ASC");

if (isset($_POST['add_product'])) {
    $category_id = (int)$_POST['category_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock']; // NEW
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image1 = $_FILES['image1']['name'];
    $tmp1 = $_FILES['image1']['tmp_name'];
    move_uploaded_file($tmp1, $uploadDir . $image1);

    $image2 = '';
    if (!empty($_FILES['image2']['name'])) {
        $image2 = $_FILES['image2']['name'];
        $tmp2 = $_FILES['image2']['tmp_name'];
        move_uploaded_file($tmp2, $uploadDir . $image2);
    }

    $image3 = '';
    if (!empty($_FILES['image3']['name'])) {
        $image3 = $_FILES['image3']['name'];
        $tmp3 = $_FILES['image3']['tmp_name'];
        move_uploaded_file($tmp3, $uploadDir . $image3);
    }

    $sql = "INSERT INTO products (category_id, name, price, stock, description, image1, image2, image3,is_featured)
            VALUES ('$category_id', '$name', '$price', '$stock', '$desc', '$image1', '$image2', '$image3','$is_featured')";

    if (mysqli_query($con, $sql)) {
        $success = "Product added successfully!";
    } else {
        $error = "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product | Admin Panel</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
</head>
<body style="margin: 0; padding: 0; overflow-x: hidden;">

<div class="page-content d-flex justify-content-center align-items-center" style="background-color: #f4f5f7; min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card border-0 shadow-lg rounded-4 mb-4">
                    <div class="card-body px-4 py-5">
                        <h3 class="fw-semibold text-center mb-4 text-dark">Add Product</h3>

                        <?php if ($success): ?><div class="alert alert-success text-center"><?= $success ?></div><?php endif; ?>
                        <?php if ($error): ?><div class="alert alert-danger text-center"><?= $error ?></div><?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Price (₹)</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Stock Quantity</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3"><label>Image 1 (Required)</label><input type="file" name="image1" class="form-control" required></div>
                            <div class="mb-3"><label>Image 2</label><input type="file" name="image2" class="form-control"></div>
                            <div class="mb-3"><label>Image 3</label><input type="file" name="image3" class="form-control"></div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>
                            <div class="text-end">
                                <button type="submit" name="add_product" class="btn btn-primary px-4">Add Product</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
