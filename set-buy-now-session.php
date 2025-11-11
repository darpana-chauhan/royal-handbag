<?php
session_start();
include 'connection.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must login first']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'], $data['name'], $data['price'], $data['image'], $data['quantity'])) {
    $product_id = intval($data['id']);
    $quantity = intval($data['quantity']);

    // Check if product exists and stock is enough
    $product_check = mysqli_query($con, "SELECT stock FROM products WHERE id = $product_id");
    if (mysqli_num_rows($product_check) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        exit();
    }
    $product = mysqli_fetch_assoc($product_check);
    if ($product['stock'] < $quantity) {
        echo json_encode(['status' => 'error', 'message' => 'Not enough stock']);
        exit();
    }

    // Set buy now session
    $_SESSION['buy_now'] = true;
    $_SESSION['buy_now_product'] = [
        'id' => $product_id,
        'name' => $data['name'],
        'price' => $data['price'],
        'image' => $data['image'],
        'quantity' => $quantity
    ];

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product data']);
}
?>
