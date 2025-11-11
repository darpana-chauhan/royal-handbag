<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$from = isset($_GET['from']) ? $_GET['from'] : 'index.php';

if ($product_id <= 0) {
    header("Location: {$from}?wish=invalid");
    exit();
}

$check_sql = "SELECT * FROM products WHERE id = $product_id";
$product_exists = mysqli_query($con, $check_sql);
if (mysqli_num_rows($product_exists) == 0) {
    header("Location: {$from}?wish=invalid");
    exit();
}

// Check if already in wishlist
$check_sql = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
$check_result = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    $insert_sql = "INSERT INTO wishlist (user_id, product_id, created_at) VALUES ($user_id, $product_id, NOW())";
    mysqli_query($con, $insert_sql);
}

header("Location: {$from}?wish=added");
exit();




