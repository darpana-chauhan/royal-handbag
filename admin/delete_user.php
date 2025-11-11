<?php
// delete_user.php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the user from the database
    $deleteQuery = "DELETE FROM registration WHERE id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('User deleted successfully'); location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user'); location.href='users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid Request'); location.href='users.php';</script>";
}
?>
