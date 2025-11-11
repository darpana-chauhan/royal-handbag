<?php
session_start();
include 'connection.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$order_query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
$order_result = mysqli_query($con, $order_query);

?>

<div class="container mt-5 mb-5">
    <h3 class="text-primary text-center mb-4">My Orders</h3>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($order_result) > 0): ?>
                    <?php while ($order = mysqli_fetch_assoc($order_result)): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></td>
                            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
                            <td><?= strtoupper(htmlspecialchars($order['payment_method'])) ?></td>
                            <td>
                                <span class="badge 
                                    <?php
                                        if ($order['status'] == 'Pending') echo 'bg-warning text-dark';
                                        elseif ($order['status'] == 'Shipped') echo 'bg-info text-dark';
                                        elseif ($order['status'] == 'Delivered') echo 'bg-success';
                                        else echo 'bg-secondary';
                                    ?>">
                                    <?= $order['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="order-details.php?order_id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-muted">You have not placed any orders yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
