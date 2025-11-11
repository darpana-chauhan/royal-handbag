<?php
session_start();

include 'header.php';
include 'connection.php';

// =================== Categories ===================
$categories_result = mysqli_query($con, "SELECT * FROM categories ORDER BY name ASC");

// =================== Wishlist & Likes ===================
$wishlist_items = [];
$like_counts = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // User wishlist items
    $wishlist_query = "SELECT product_id FROM wishlist WHERE user_id = $user_id";
    $wishlist_result = mysqli_query($con, $wishlist_query);
    while ($row = mysqli_fetch_assoc($wishlist_result)) {
        $wishlist_items[] = $row['product_id'];
    }

    // Like counts
    $like_query = "SELECT product_id, COUNT(*) as total FROM wishlist GROUP BY product_id";
    $like_result = mysqli_query($con, $like_query);
    while ($row = mysqli_fetch_assoc($like_result)) {
        $like_counts[$row['product_id']] = $row['total'];
    }
}

// =================== Search Handling ===================
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (!empty($q)) {
    $safe_q = mysqli_real_escape_string($con, $q);

    // 🔎 Search words split
    $words = explode(" ", $safe_q);
    $conditions = [];

    foreach ($words as $word) {
        $word = mysqli_real_escape_string($con, $word);
        $conditions[] = "(p.name LIKE '%$word%' 
                          OR c.name LIKE '%$word%' 
                          OR p.description LIKE '%$word%')";
    }

    // All words must match
    $where = implode(" AND ", $conditions);

    $product_sql = "SELECT p.*, c.name AS category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE $where
                    ORDER BY p.id DESC";
} else {
    // No search → show all
    $product_sql = "SELECT p.*, c.name AS category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    ORDER BY p.id DESC";
}

$product_result = mysqli_query($con, $product_sql);
?>

<!-- =================== PAGE CONTENT =================== -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">

        <!-- ✅ Category Filters: Only show when NOT searching -->
        <?php if (empty($q)): ?>
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10 isotope-filter">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">All Products</button>
                <?php while ($category = mysqli_fetch_assoc($categories_result)) {
                    $cat_name = htmlspecialchars($category['name']);
                    $class_name = strtolower(str_replace(' ', '-', $cat_name)); ?>
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" 
                            data-filter=".<?= $class_name ?>"><?= $cat_name ?></button>
                <?php } ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Product Grid -->
        <div class="row isotope-grid">
            <?php if (mysqli_num_rows($product_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($product_result)) {
                    $id = $product['id'];
                    $name = htmlspecialchars($product['name']);
                    $price = number_format($product['price'], 2);
                    $image = htmlspecialchars($product['image1']);
                    $category_class = strtolower(str_replace(' ', '-', $product['category_name']));
                    $is_wishlisted = in_array($id, $wishlist_items);
                ?>
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item <?= $category_class ?>">
                    <div class="block2">
                        <div class="block2-pic hov-img0 pos-relative">
                            <img src="admin/uploads/<?= $image ?>" alt="<?= $name ?>" style="height:300px; object-fit:cover;">
                            <div class="block2-overlay trans-0-4 flex-c-m flex-col-c p-lr-25 p-tb-30">
                                <a href="product-detail.php?id=<?= $id ?>" 
                                   class="flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 m-b-10 trans-04">
                                   Quick View
                                </a>
                                <!-- ✅ Add to Cart via JS -->
                                <button class="flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 m-b-10 trans-04 add-cart-btn" 
                                        data-id="<?= $id ?>">Add to Cart</button>
                            </div>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="product-detail.php?id=<?= $id ?>" 
                                   class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"><?= $name ?></a>
                                <span class="stext-105 cl3">₹<?= $price ?></span>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <button class="wishlist-btn" data-id="<?= $id ?>" style="background:none; border:none;">
                                        <img id="wishlist-icon-<?= $id ?>" 
                                             src="images/icons/<?= $is_wishlisted ? 'icon-heart-02.png' : 'icon-heart-01.png' ?>">
                                    </button>
                                    <span class="small text-muted">
                                        ❤️ <span id="like-count-<?= $id ?>"><?= $like_counts[$id] ?? 0 ?></span> 
                                        like<?= ($like_counts[$id] ?? 0) == 1 ? '' : 's' ?>
                                    </span>
                                </div>
                                <?php else: ?>
                                    <a href="login.php"><img src="images/icons/icon-heart-01.png"></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php else: ?>
                <p class="text-center w-100">No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- =================== Wishlist & Cart JS =================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Wishlist toggle
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            fetch('wishlist-toggle.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + productId
            })
            .then(res => res.json())
            .then(data => {
                const icon = document.getElementById('wishlist-icon-' + data.product_id);
                const countSpan = document.getElementById('like-count-' + data.product_id);

                if (icon) icon.src = data.status === 'added' ? 'images/icons/icon-heart-02.png' : 'images/icons/icon-heart-01.png';
                if (countSpan && data.like_count !== undefined) countSpan.textContent = data.like_count;

                // Update header wishlist count
                fetch('get-wishlist-count.php')
                    .then(res => res.json())
                    .then(countData => {
                        const headerWishlist = document.getElementById('wishlist-count');
                        if (headerWishlist) headerWishlist.setAttribute('data-notify', countData.count);
                    });
            });
        });
    });

    // Add to Cart
    const addCartButtons = document.querySelectorAll('.add-cart-btn');
    addCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');

            <?php if (!isset($_SESSION['user_id'])): ?>
                // ⚡ Not logged in → redirect to login page
                window.location.href = "login.php?redirect=" + encodeURIComponent(window.location.href);
            <?php else: ?>
                // Logged in → add to cart
                fetch('add-to-cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + productId + '&quantity=1'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 1200
                        });

                        // Update header cart count live
                        const headerCart = document.querySelectorAll('.icon-header-item.js-show-cart');
                        headerCart.forEach(el => {
                            el.setAttribute('data-notify', data.cart_count);
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                });
            <?php endif; ?>
        });
    });

});
</script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
