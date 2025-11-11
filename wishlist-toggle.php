<?php
session_start();
include 'connection.php';

// Check if request method is POST and product_id + user_id are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_SESSION['user_id'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];
    $status = '';

    // Check if product already in wishlist
    $check_query = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Remove from wishlist
        mysqli_query($con, "DELETE FROM wishlist WHERE user_id = $user_id AND product_id = $product_id");
        $status = 'removed';
    } else {
        // Add to wishlist
        mysqli_query($con, "INSERT INTO wishlist (user_id, product_id, created_at) VALUES ($user_id, $product_id, NOW())");
        $status = 'added';
    }

    // Get updated like count for the product
    $count_result = mysqli_query($con, "SELECT COUNT(*) AS total FROM wishlist WHERE product_id = $product_id");
    $like_data = mysqli_fetch_assoc($count_result);
    $like_count = $like_data['total'] ?? 0;

    // Respond with JSON
    echo json_encode([
        'status' => $status,
        'product_id' => $product_id,
        'like_count' => $like_count
    ]);
    exit;
} else {
    // Invalid request
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request or not logged in'
    ]);
    exit;
}
?>
