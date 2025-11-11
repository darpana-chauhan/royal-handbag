<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate wishlist ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: wishlist.php?error=invalid_id");
    exit();
}

$wishlist_id = intval($_GET['id']);

// Verify that this wishlist item belongs to the logged-in user
$check_sql = "SELECT * FROM wishlist WHERE id = $wishlist_id AND user_id = $user_id";
$check_result = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_result) === 1) {
    // Item found, delete it
    $delete_sql = "DELETE FROM wishlist WHERE id = $wishlist_id";
    mysqli_query($con, $delete_sql);

    // Redirect with success message (optional)
    header("Location: wishlist.php?removed=success");
    exit();
} else {
    // Item not found or doesn't belong to user
    header("Location: wishlist.php?error=not_found");
    exit();
}
?>
