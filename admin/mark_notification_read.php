<?php
include 'connection.php';
mysqli_query($con, "UPDATE notifications SET status='read' WHERE status='unread'");
?>
