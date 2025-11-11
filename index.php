<?php
session_start();
include 'header.php';
include 'connection.php';
?>
<!-- Slider--> 
<section class="section-slide">
	<div class="wrap-slick1">
		<div class="slick1">
			<div class="item-slick1" style="background-image: url(images/01.jpg);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								 Royal Handbag Collection
							</span>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								Elegant. Timeless. You.
							</h2>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
							<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="item-slick1" style="background-image: url(images/02.jpg);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
							<span class="ltext-101 cl2 respon2">
							  Stylish New Arrivals
							</span>
						  </div>
						  
						  <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
							  Premium Purses & Bags
							</h2>
						  </div>
						  
						  <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
							<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
							  Shop Now
							</a>
						  </div>
					</div>
				</div>
			</div>
					
			<div class="item-slick1" style="background-image:url(images/03.jpeg);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								Handbag Collection 2025
							</span>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								New arrivals
							</h2>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
							<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="item-slick1" style="background-image: url(images/04.jpg);">
				<div class="container h-full">
					<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
						<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
							<span class="ltext-101 cl2 respon2">
								Handbag Collection 2025
							</span>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
							<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
								New arrivals
							</h2>
						</div>
							
						<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
							<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
								Shop Now
							</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- Features Section -->
<section style="padding: 60px 20px; background-color: #f7f7f7; text-align: center;">
    <div style="max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-around; flex-wrap: wrap; gap: 40px;">
        <div style="flex: 1 1 250px;">
            <img src="images/transport.png" alt="Free Shipping" style="width: 70px; margin-bottom: 20px;">
            <h3>Free Shipping</h3>
            <p>On all orders over ₹1000. Fast and reliable delivery.</p>
        </div>
        <div style="flex: 1 1 250px;">
            <img src="images/high-quality.png" alt="Quality Products" style="width: 70px; margin-bottom: 20px;">
            <h3>Premium Quality</h3>
            <p>We offer only the best quality handbags with authentic materials.</p>
        </div>
        <!--<div style="flex: 1 1 250px;">
            <img src="images/return.png" alt="Easy Returns" style="width: 70px; margin-bottom: 20px;">
            <h3>Easy Returns</h3>
            <p>Hassle-free returns within 30 days of purchase.</p>
        </div>-->
    </div>
</section>

<!-- About Us Section -->
<section style="max-width: 1100px; margin: 60px auto; padding: 0 20px; display: flex; align-items: center; flex-wrap: wrap; gap: 40px;">
    <div style="flex: 1 1 400px;">
        <img src="images/about-us.jpg" alt="About Royal Handbags" style="width: 100%; border-radius: 0px; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
    </div>
    <div style="flex: 1 1 400px;">
        <h2>About Royal Handbag Collection</h2>
        <p style="font-size: 1.1rem; line-height: 1.6; color: #555;">
            Royal Handbag Collection is dedicated to bringing you timeless, elegant, and premium handbags crafted with the utmost care. Our passion is to empower your style with quality and sophistication. Whether for daily use or special occasions, our collection has something for everyone.
        </p>
        <a href="about.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" 
        style="display: inline-block; margin-top: 20px;   padding: 12px 30px; text-decoration: none; ">Learn More</a>
    </div>
</section>



<?php
include 'footer.php';
?>

<script>
// Simple Testimonials slider
document.addEventListener('DOMContentLoaded', () => {
    let testimonials = document.querySelectorAll('.testimonial');
    let current = 0;

    function showTestimonial(index) {
        testimonials.forEach((t, i) => {
            t.style.display = (i === index) ? 'block' : 'none';
        });
    }

    document.getElementById('prevTestimonial').addEventListener('click', () => {
        current = (current - 1 + testimonials.length) % testimonials.length;
        showTestimonial(current);
    });

    document.getElementById('nextTestimonial').addEventListener('click', () => {
        current = (current + 1) % testimonials.length;
        showTestimonial(current);
    });

    showTestimonial(current);
});
</script>