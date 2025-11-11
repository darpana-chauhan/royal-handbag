<?php
session_start();
include 'connection.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist items with product details
$wishlist_sql = "SELECT w.id as wishlist_id, p.id as product_id, p.name, p.price, p.image1 
                 FROM wishlist w 
                 JOIN products p ON w.product_id = p.id 
                 WHERE w.user_id = $user_id";
$wishlist_result = mysqli_query($con, $wishlist_sql);

$wishlist_items = [];
$total_amount = 0;

while ($row = mysqli_fetch_assoc($wishlist_result)) {
    $wishlist_items[] = $row;
    $total_amount += $row['price'];
}
?>

<!-- Wishlist Section -->
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Wishlist Items -->
        <div class="col-lg-8">
            <h4 class="mb-4 text-primary">My Wishlist</h4>
            <?php if (count($wishlist_items) > 0): ?>
                <?php foreach ($wishlist_items as $item): ?>
                    <div class="card mb-3 shadow-sm border-0 rounded-4">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="admin/uploads/<?= htmlspecialchars($item['image1']) ?>" class="img-fluid rounded-start" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title mb-2"><?= htmlspecialchars($item['name']) ?></h5>
                                    <p class="card-text text-danger mb-3">Price: ₹<?= number_format($item['price'], 2) ?></p>
                                    <a href="add-to-cart.php?id=<?= $item['product_id'] ?>" class="btn btn-primary btn-sm me-2">
                                        <i class="fa fa-cart-plus me-1"></i> Add to Cart
                                    </a>
                                    <a href="remove-wishlist.php?id=<?= $item['wishlist_id'] ?>" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-trash me-1"></i> Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Your wishlist is empty.</div>
            <?php endif; ?>
        </div>

        <!-- Wishlist Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="card-title">Wishlist Summary</h5>
                    <hr>
                    <p>Total Items: <strong><?= count($wishlist_items) ?></strong></p>
                    <p>Total Estimated Value: <strong class="text-danger">₹<?= number_format($total_amount, 2) ?></strong></p>
                    <a href="product.php" class="btn btn-primary w-100 mt-3">
                        <i class="fa fa-shopping-bag me-1"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
