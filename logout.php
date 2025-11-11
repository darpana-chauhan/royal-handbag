<?php
session_start();
include 'connection.php';

// Clear session variables
unset($_SESSION['username']);
unset($_SESSION['user_id']);
unset($_SESSION['user_img']);

// Optional: clear cart from session (already not needed with DB cart)
unset($_SESSION['cart']);

header("Location: index.php");
exit();
?>