<?php
session_start();
include "connection.php";

// =================== Get Product ===================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$id = intval($_GET['id']);

$product_result = mysqli_query($con, "SELECT p.*, c.name AS category_name 
                                      FROM products p 
                                      LEFT JOIN categories c ON p.category_id = c.id 
                                      WHERE p.id = $id");
if (mysqli_num_rows($product_result) !== 1) {
    header("Location: index.php");
    exit();
}
$product = mysqli_fetch_assoc($product_result);

include "header.php";

// =================== Wishlist + Like Counts ===================
$wishlist_items = [];
$like_counts = [];
$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id) {
    // User wishlist items
    $wishlist_result = mysqli_query($con, "SELECT product_id FROM wishlist WHERE user_id = $user_id");
    while ($row = mysqli_fetch_assoc($wishlist_result)) {
        $wishlist_items[] = $row['product_id'];
    }

    // Like counts
    $like_result = mysqli_query($con, "SELECT product_id, COUNT(*) as total FROM wishlist GROUP BY product_id");
    while ($row = mysqli_fetch_assoc($like_result)) {
        $like_counts[$row['product_id']] = $row['total'];
    }
}

// =================== Related Products ===================
$related_result = mysqli_query($con, "SELECT p.*, c.name AS category_name 
                                     FROM products p 
                                     LEFT JOIN categories c ON p.category_id = c.id 
                                     ORDER BY p.id DESC");

// =================== Feedback ===================
$feedback_result = mysqli_query($con, "SELECT f.*, r.name 
                                      FROM feedbacks f 
                                      JOIN registration r ON f.user_id = r.id 
                                      WHERE f.product_id = $id 
                                      ORDER BY f.created_at DESC");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container p-5">
    <div class="row d-flex align-items-start gap-4">
        <!-- Thumbnails -->
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-start">
                <?php foreach (['image1','image2','image3'] as $imgKey): 
                    if (!empty($product[$imgKey])): ?>
                    <img class="img-thumbnail mb-2 thumb-img" style="width:100px; cursor:pointer;" src="admin/uploads/<?= htmlspecialchars($product[$imgKey]) ?>" alt="Thumb">
                <?php endif; endforeach; ?>
            </div>
        </div>

        <!-- Main Image -->
        <div class="col-md-5">
            <img id="main-image" src="admin/uploads/<?= htmlspecialchars($product['image1']) ?>" class="img-fluid border" style="width:100%;">
        </div>

        <!-- Product Details -->
        <div class="col-md-4 ps-md-5">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <h4 class="text-success mb-3">₹<?= number_format($product['price'],2) ?></h4>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <p><strong>Stock:</strong>
                <?= $product['stock'] > 0 ? "<span class='text-success'>{$product['stock']} in stock</span>" : "<span class='text-danger'>Out of Stock</span>" ?>
            </p>

            <!-- Wishlist -->
            <?php $is_wishlisted = in_array($product['id'],$wishlist_items); ?>
            <button class="wishlist-btn mb-3" data-id="<?= $product['id'] ?>" style="background:none; border:none;">
                <img id="wishlist-icon-<?= $product['id'] ?>" src="images/icons/<?= $is_wishlisted ? 'icon-heart-02.png':'icon-heart-01.png' ?>" alt="Wishlist">
            </button>
            <span class="small text-muted">
                ❤️<span id="like-count-<?= $id ?>"><?= $like_counts[$id] ?? 0 ?></span> like<?= ($like_counts[$id] ?? 0)==1?'':'s' ?>
            </span>

            <?php if($product['stock'] > 0): ?>
            <!-- Quantity -->
            <div class="d-flex align-items-center gap-2 mt-3">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-qty-down"><i class="bi bi-dash-lg"></i></button>
                <input class="form-control text-center qty-input" type="number" value="1" min="1" max="<?= $product['stock'] ?>" style="width:80px;">
                <button type="button" class="btn btn-outline-secondary btn-sm btn-qty-up"><i class="bi bi-plus-lg"></i></button>
            </div>

            <!-- Buttons -->
            <div class="mt-3 d-flex gap-2">
                <button class="btn btn-success buy-now-btn" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= $product['price'] ?>" data-image="<?= htmlspecialchars($product['image1']) ?>">Buy Now</button>
                &nbsp;&nbsp;<button class="btn btn-primary add-cart-btn" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= $product['price'] ?>" data-image="<?= htmlspecialchars($product['image1']) ?>">Add to Cart</button>
            </div>
            <?php else: ?>
                <button class="btn btn-secondary mt-3" disabled>Out of Stock</button>
            <?php endif; ?>
        </div>

        <!-- Feedback Section -->
        <div class="mt-5 col-12">
            <h4 class="text-primary">User Feedback</h4>
            <?php if(mysqli_num_rows($feedback_result) > 0): ?>
                <?php while($fb=mysqli_fetch_assoc($feedback_result)): ?>
                <div class="border rounded-3 p-3 mb-3 shadow-sm bg-light">
                    <strong><?= htmlspecialchars($fb['name']) ?></strong>
                    <p><?= nl2br(htmlspecialchars($fb['comment'])) ?></p>
                    <?php if(!empty($fb['image'])): ?>
                    <img src="<?= htmlspecialchars($fb['image']) ?>" alt="Feedback Image" class="img-thumbnail" style="max-width:200px;">
                    <?php endif; ?>
                    <small class="text-muted"><?= date("d M Y, h:i A",strtotime($fb['created_at'])) ?></small>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No feedback yet for this product.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<div class="bg0 mt-5 p-b-140">
    <div class="container">
        <h4 class="mb-4 text-primary">Related Products</h4>
        <div class="row isotope-grid">
            <?php mysqli_data_seek($related_result,0); ?>
            <?php while($related = mysqli_fetch_assoc($related_result)):
                $rid = $related['id'];
                $rname = htmlspecialchars($related['name']);
                $rprice = number_format($related['price'],2);
                $rimg = htmlspecialchars($related['image1']);
                $is_wishlisted = in_array($rid,$wishlist_items);
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                <div class="block2">
                    <div class="block2-pic hov-img0 pos-relative">
                        <img src="admin/uploads/<?= $rimg ?>" alt="<?= $rname ?>" style="height:300px; object-fit:cover;">
                        <div class="block2-overlay trans-0-4 flex-c-m flex-col-c p-lr-25 p-tb-30">
                            <a href="product-detail.php?id=<?= $rid ?>" class="flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 m-b-10 trans-04">Quick View</a>
                            <button class="flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 m-b-10 trans-04 add-cart-btn" data-id="<?= $rid ?>">Add to Cart</button>
                        </div>
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.php?id=<?= $rid ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"><?= $rname ?></a>
                            <span class="stext-105 cl3">₹<?= $rprice ?></span>
                            
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <button class="wishlist-btn" data-id="<?= $rid ?>" style="background:none; border:none;">
                                    <img id="wishlist-icon-<?= $rid ?>" src="images/icons/<?= $is_wishlisted?'icon-heart-02.png':'icon-heart-01.png' ?>" alt="Wishlist">
                                </button>
                                <span class="small text-muted">❤️ <span id="like-count-<?= $rid ?>"><?= $like_counts[$rid] ?? 0 ?></span> like<?= ($like_counts[$rid] ?? 0)==1?'':'s' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Quantity controls
    document.querySelectorAll('.btn-qty-up').forEach(btn=>{
        btn.addEventListener('click', ()=> {
            const input = btn.parentElement.querySelector('.qty-input');
            if(parseInt(input.value) < parseInt(input.max)) input.value = parseInt(input.value)+1;
        });
    });
    document.querySelectorAll('.btn-qty-down').forEach(btn=>{
        btn.addEventListener('click', ()=> {
            const input = btn.parentElement.querySelector('.qty-input');
            if(parseInt(input.value) > parseInt(input.min)) input.value = parseInt(input.value)-1;
        });
    });

    // Buy Now
    document.querySelectorAll('.buy-now-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            const qty = document.querySelector('.qty-input').value || 1;
            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price,
                image: this.dataset.image,
                quantity: qty
            };
            fetch('set-buy-now-session.php',{
                method:'POST',
                headers:{'Content-Type':'application/json'},
                body: JSON.stringify(product)
            }).then(()=>{ window.location.href='checkout.php'; });
        });
    });

    // Add to Cart
    const addCartButtons = document.querySelectorAll('.add-cart-btn');
    addCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            <?php if(!$user_id): ?> 
                window.location.href = "login.php";
                return;
            <?php endif; ?>

            const productId = this.getAttribute('data-id');
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
                    document.querySelectorAll('.icon-header-item.js-show-cart').forEach(el=>{
                        el.setAttribute('data-notify', data.cart_count);
                    });
                } else {
                    Swal.fire({icon: 'error', title: 'Error', text: data.message});
                }
            });
        });
    });

    // Wishlist toggle
    document.querySelectorAll('.wishlist-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            <?php if(!$user_id): ?> 
                window.location.href = "login.php";
                return;
            <?php endif; ?>

            const pid = this.dataset.id;
            fetch('wishlist-toggle.php',{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:'product_id='+pid
            }).then(res=>res.json()).then(data=>{
                const icon = document.getElementById('wishlist-icon-'+data.product_id);
                const countSpan = document.getElementById('like-count-'+data.product_id);
                if(icon) icon.src = data.status==='added'?'images/icons/icon-heart-02.png':'images/icons/icon-heart-01.png';
                if(countSpan && data.like_count!==undefined) countSpan.textContent = data.like_count;

                fetch('get-wishlist-count.php').then(res=>res.json()).then(countData=>{
                    const headerWishlist = document.getElementById('wishlist-count');
                    if(headerWishlist) headerWishlist.setAttribute('data-notify', countData.count);
                });
            });
        });
    });

    // Thumbnail click
    document.querySelectorAll('.thumb-img').forEach(thumb=>{
        thumb.addEventListener('click', ()=> document.getElementById('main-image').src = thumb.src);
    });
});
</script>

<?php include 'footer.php'; ?>
