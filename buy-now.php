<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($con, $sql);

    if ($product = mysqli_fetch_assoc($result)) {
        // Create product array to store in session
        $_SESSION['buy_now_product'] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image1'],
            'quantity' => $quantity
        ];

        $_SESSION['buy_now'] = true;

        // Redirect to checkout
        header("Location: checkout.php");
        exit();
    } else {
        echo "<script>alert('Product not found'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location='index.php';</script>";
}
