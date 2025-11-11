<?php
session_start();
include "connection.php";
include "header.php";

// Check if user is logged in


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No user selected.";
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM registration WHERE id = $id";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="container" style="padding:50px; max-width:600px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>User Profile</h2>
            <!-- Logout Button -->
            <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');"
                style="padding: 8px 16px; 
                        background-color: black; 
                        color: white; 
                        text-decoration: none; 
                        border-radius: 5px; 
                        transition: background-color 0.3s ease;"
                onmouseover="this.style.backgroundColor='#555';"
                onmouseout="this.style.backgroundColor='black';"
                onmousedown="this.style.backgroundColor='#444';"
                onmouseup="this.style.backgroundColor='#555';">
                Logout
            </a>

        </div>
        <hr>
        <img src="<?= htmlspecialchars($row['profile_img']) ?>" alt="Profile" style="width:150px;height:150px;border-radius:50%; margin-bottom: 20px;">
        <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone_no']) ?></p>
        <p><strong>City:</strong> <?= htmlspecialchars($row['city']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($row['country']) ?></p>
    </div>
<?php
} else {
    echo "User not found.";
}

include "footer.php";
?>
