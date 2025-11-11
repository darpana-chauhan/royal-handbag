<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mark notification as read
    mysqli_query($con, "UPDATE notifications SET status='read' WHERE id = $id");

    // Redirect to linked page
    $result = mysqli_query($con, "SELECT link FROM notifications WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $link = $row['link'] ?? 'index.php'; // fallback

    header("Location: $link");
    exit;
}
?>
