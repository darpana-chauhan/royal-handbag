<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connection.php";
include "header.php";

// Initialize error variable
$error = "";

// Handle form submission
if (isset($_POST['sub'])) {
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $pwd = mysqli_real_escape_string($con, $_POST['password']);

    // Check if username exists
    $sql_user = "SELECT * FROM registration WHERE name='$uname'";
    $res_user = mysqli_query($con, $sql_user);

    if (mysqli_num_rows($res_user) == 0) {
        // Username not found
        $error = "Invalid username!";
    } else {
        $row = mysqli_fetch_assoc($res_user);

        if ($row['password'] != $pwd) {
            // Wrong password
            $error = "Invalid password!";
        } else {
            // Successful login
            $_SESSION["username"] = $row['name'];
            $_SESSION['user_img'] = $row['profile_img'];
            $_SESSION["user_id"] = $row['id'];

            // Always redirect to index page
            echo "<script>location.href='index.php';</script>";
            exit();
        }
    }
}
?>

<!-- Login Form UI -->
<div style="display:flex;justify-content:center;align-items:center;min-height:80vh;">
    <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
        <form method="POST" action="login.php">
            <h4 class="mtext-105 cl2 txt-center p-b-30">Login to Your Account</h4>

            <?php if (!empty($error)): ?>
                <div style="color:red; text-align:center; font-weight:500; margin-bottom:15px;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label style="font-weight:500;">Username (Email or Name)</label>
                <input type="text" class="form-control" name="username" placeholder="Enter your username" required style="border-radius:5px;padding:10px;">
            </div>
            <div class="mb-4">
                <label style="font-weight:500;">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required style="border-radius:5px;padding:10px;">
            </div>
            <input type="submit" name="sub" value="Login" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 pointer" style="width:100%;border-radius:5px;transition:background 0.3s;" onmouseover="this.style.backgroundColor='#555';" onmouseout="this.style.backgroundColor='#333';">
        </form>
    </div>
</div>

<?php
mysqli_close($con);
include "footer.php";
?>
