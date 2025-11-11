<?php
session_start();
include "connection.php"; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO contact (email, message) VALUES ('$email', '$message')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Failed to send message.');</script>";
    }
}

include "header.php";
?>

<!-- Title -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">Contact</h2>
</section>

<!-- Contact Form -->
<section class="bg0" style="padding: 40px 0;">
    <div class="container">
        <div class="flex-w flex-tr">
            <!-- Contact Form -->
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-50 p-lr-15-lg w-full-md">
                <form method="POST" action="contact.php">
                    <h4 class="mtext-105 cl2 txt-center p-b-30">Send Us A Message</h4>

                    <div class="bor8 m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" 
                            type="email" name="email" placeholder="Your Email Address" required>
                        <img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
                    </div>

                    <div class="bor8 m-b-30">
                        <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" 
                            name="message" placeholder="How Can We Help?" required></textarea>
                    </div>

                    <button type="submit" 
                        class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                        Submit
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="size-210 bor10 flex-w flex-col-m p-lr-70 p-t-55 p-b-50 p-lr-15-lg w-full-md">
                <div class="flex-w w-full p-b-42">
                    <span class="fs-18 cl5 txt-center size-211">
                        <span class="lnr lnr-map-marker"></span>
                    </span>
                    <div class="size-212 p-t-2">
                        <span class="mtext-110 cl2">Address</span>
                        <p class="stext-115 cl6 size-213 p-t-18">
                            Royal Handbag Store, Junagadh, Gujarat - 362001, India
                        </p>
                    </div>
                </div>

                <div class="flex-w w-full p-b-42">
                    <span class="fs-18 cl5 txt-center size-211">
                        <span class="lnr lnr-phone-handset"></span>
                    </span>
                    <div class="size-212 p-t-2">
                        <span class="mtext-110 cl2">Let's Talk</span>
                        <p class="stext-115 cl1 size-213 p-t-18">+91 98765 43210</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Google Map Junagadh -->
<div class="map" style="height:450px; margin-bottom:0;">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3708.7032969933456!2d70.45976887491515!3d21.52218417171516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3958010e4bda8913%3A0x52b40182fd6d174c!2sJunagadh%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1693470000000!5m2!1sen!2sin" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<?php include "footer.php"; ?>
