<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $insert = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    $run = mysqli_query($con, $insert);

    if ($run) {
        $message = "New user registered: $name";
        $link = "user.php";

        $notification_sql = "INSERT INTO notifications (message, link, status, created_at) 
                             VALUES ('$message', '$link', 'unread', NOW())";

        if (!mysqli_query($con, $notification_sql)) {
            echo "Notification error: " . mysqli_error($con);
        }

        echo "<script>alert('Registration successful'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed');</script>";
    }
}
?>
