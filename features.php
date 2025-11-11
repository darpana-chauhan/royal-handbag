<?php
session_start();
include 'connection.php';
include 'header.php';

// Featured products को select करो (मान लो, एक column है 'is_featured' in products table)
$query = "SELECT * FROM products WHERE is_featured = 1 ORDER BY id DESC";
$result = mysqli_query($con, $query);
?>

<div class="container my-5">
    <h2 class="text-center mb-4 text-uppercase">✨ Featured Products ✨</h2>
    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="admin/uploads/<?= $row['image1'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height:250px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <p class="card-text text-success">₹<?= number_format($row['price'], 2) ?></p>
                            <a href="product-detail.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="alert alert-warning">No featured products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
