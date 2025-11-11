<?php
session_start();
include "connection.php";

$count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($con, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
    $data = mysqli_fetch_assoc($query);
    $count = $data['total'] ?? 0;
}

echo json_encode(['count' => $count]);
?>