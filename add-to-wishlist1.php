<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$from = isset($_GET['from']) ? $_GET['from'] : 'index.php';

// Product valid check
$check_product = mysqli_query($con, "SELECT id FROM products WHERE id = $product_id");
if (mysqli_num_rows($check_product) == 0) {
    header("Location: $from&wish=invalid");
    exit;
}

// Wishlist logic
$check = mysqli_query($con, "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
if (mysqli_num_rows($check) > 0) {
    mysqli_query($con, "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
    header("Location: $from&wish=removed");
} else {
    mysqli_query($con, "INSERT INTO wishlist (user_id, product_id, created_at) VALUES ($user_id, $product_id, NOW())");
    header("Location: $from&wish=added");
}
exit();
?>
