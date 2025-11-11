<?php
session_start();
include '../connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_products.php");
    exit;
}

$id = intval($_GET['id']);

// Step 1: Get product with images and featured status
$sql = "SELECT image1, image2, image3, is_featured FROM products WHERE id = $id";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 1) {
    $product = mysqli_fetch_assoc($result);

    // Step 2: Delete images if they exist
    $image_paths = ['image1', 'image2', 'image3'];
    foreach ($image_paths as $img) {
        if (!empty($product[$img]) && file_exists("uploads/" . $product[$img])) {
            unlink("uploads/" . $product[$img]);
        }
    }

    // Step 3: Delete the product
    mysqli_query($con, "DELETE FROM products WHERE id = $id");
}

// Step 4: Redirect to view products page
header("Location: view_products.php");
exit;
?>
