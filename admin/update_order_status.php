<?php
include 'connection.php';

$order_id = $_POST['order_id'];
$status = $_POST['status'];

mysqli_query($con, "UPDATE orders SET status = '$status' WHERE id = $order_id");

header("Location: orders.php"); // redirect to admin page
exit();