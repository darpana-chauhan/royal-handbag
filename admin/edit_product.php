<?php
session_start();
include '../connection.php'; // Connection sabse pehle
ob_start(); // Output buffering start

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_products.php");
    exit;
}

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM products WHERE id=$id"));
$categories = mysqli_query($con, "SELECT * FROM categories");

if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = $_POST['price'];
    $stock = (int)$_POST['stock'];
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = $_POST['category_id'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Images
    $image1 = $product['image1'];
    if (!empty($_FILES['image1']['name'])) {
        $image1 = $_FILES['image1']['name'];
        move_uploaded_file($_FILES['image1']['tmp_name'], 'uploads/' . $image1);
    }

    $image2 = $product['image2'];
    if (!empty($_FILES['image2']['name'])) {
        $image2 = $_FILES['image2']['name'];
        move_uploaded_file($_FILES['image2']['tmp_name'], 'uploads/' . $image2);
    }

    $image3 = $product['image3'];
    if (!empty($_FILES['image3']['name'])) {
        $image3 = $_FILES['image3']['name'];
        move_uploaded_file($_FILES['image3']['tmp_name'], 'uploads/' . $image3);
    }

    // Update query
    $sql = "UPDATE products SET 
            name='$name', 
            price='$price', 
            stock='$stock',
            description='$desc', 
            category_id='$category_id',
            image1='$image1',
            image2='$image2',
            image3='$image3',
            is_featured='$is_featured'
            WHERE id=$id";

    if (mysqli_query($con, $sql)) {
        // Clear any previous output
        ob_clean();
        header("Location: view_products.php");
        exit;
    } else {
        $error = "Error updating product: " . mysqli_error($con);
    }
}

ob_end_flush(); // Flush the output
include 'header.php';
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product | Admin Panel</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
</head>
<body style="background-color: #f4f5f7; margin: 0; padding: 0; overflow-x: hidden;">

<div class="main-content" style="margin-left: 250px; padding: 40px 30px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow rounded-4 mb-5">
                    <div class="card-body p-5">
                        <h3 class="text-center text-primary fw-bold mb-4">Edit Product</h3>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Price (₹)</label>
                                    <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control" required>
                                    <?php while ($cat = mysqli_fetch_assoc($categories)) : ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Image 1</label>
                                    <input type="file" name="image1" class="form-control">
                                    <?php if (!empty($product['image1'])): ?>
                                        <img src="uploads/<?= $product['image1'] ?>" class="img-thumbnail mt-2" width="100">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Image 2</label>
                                    <input type="file" name="image2" class="form-control">
                                    <?php if (!empty($product['image2'])): ?>
                                        <img src="uploads/<?= $product['image2'] ?>" class="img-thumbnail mt-2" width="100">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Image 3</label>
                                    <input type="file" name="image3" class="form-control">
                                    <?php if (!empty($product['image3'])): ?>
                                        <img src="uploads/<?= $product['image3'] ?>" class="img-thumbnail mt-2" width="100">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>

                            <div class="text-end">
                                <button type="submit" name="update_product" class="btn btn-success px-4">Update Product</button>
                                <a href="view_products.php" class="btn btn-outline-secondary ms-2">Cancel</a>
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
