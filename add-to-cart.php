<?php
session_start();
include 'connection.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'You must login first']);
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}

$user_id = $_SESSION['user_id'];

// AJAX POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantity'])) {
    $product_id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);

    // Check product exists
    $product_check = mysqli_query($con, "SELECT id, stock FROM products WHERE id = $product_id");
    if (mysqli_num_rows($product_check) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        exit();
    }
    $product = mysqli_fetch_assoc($product_check);

    if ($product['stock'] < $quantity) {
        echo json_encode(['status' => 'error', 'message' => 'Not enough stock']);
        exit();
    }

    // Add/update cart
    $cart_check = mysqli_query($con, "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    if (mysqli_num_rows($cart_check) > 0) {
        mysqli_query($con, "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        mysqli_query($con, "INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES ($user_id, $product_id, $quantity, NOW())");
    }

    // ✅ New: Get updated cart count
    $count_result = mysqli_query($con, "SELECT SUM(quantity) AS total FROM cart WHERE user_id = $user_id");
    $count_data = mysqli_fetch_assoc($count_result);
    $cart_count = $count_data['total'] ?? 0;

    echo json_encode([
        'status' => 'success',
        'message' => 'Added to cart',
        'cart_count' => $cart_count
    ]);
    exit();
}

// Fallback
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit();
?>
