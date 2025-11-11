<?php
session_start();
include 'connection.php';

$count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($con, "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $user_id");
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $count = $data['count'];
    }
}

header('Content-Type: application/json');
echo json_encode(['count' => $count]);
?>