<?php 
include "connection.php";
include "header.php";
if (isset($_SESSION['user_id'])) {
    echo "<script>location.href='user_profile.php?id={$_SESSION['user_id']}';</script>";
    exit;
}
?>

<div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">
  <div class="size-210 bor10 p-4 w-full-md" style="max-width:500px;">
    <form id="registerForm" method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
      <h4 class="mtext-105 cl2 text-center mb-4">Create Your Account</h4>

      <!-- Full Name -->
      <div class="mb-3">
        <label for="name" class="form-label fw-medium">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
        <div class="invalid-feedback">Please enter your full name.</div>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label fw-medium">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        <div class="invalid-feedback">Please enter a valid email.</div>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label fw-medium">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
        <div class="invalid-feedback">Please enter a password.</div>
      </div>

      <!-- Confirm -->
      <div class="mb-4">
        <label for="confirm_password" class="form-label fw-medium">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
        <div class="invalid-feedback" id="confirmPasswordFeedback">Please confirm your password.</div>
      </div>

      <!-- Phone -->
      <div class="mb-3">
        <label for="phone" class="form-label fw-medium">Phone No</label>
        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone" required pattern="^\d{10}$" maxlength="10">
        <div class="invalid-feedback">Phone must be 10 digits.</div>
      </div>

      <!-- Country/State/City -->
      <div class="row">
        <div class="col mb-3">
          <label for="country" class="form-label fw-medium">Country</label>
          <select class="form-control" id="country" name="country" required>
            <option value="">Select Country</option>
            <?php
              $cqry = mysqli_query($con, "SELECT * FROM country ORDER BY name");
              while($crow = mysqli_fetch_assoc($cqry)){
                echo "<option value='".$crow['id']."'>".$crow['name']."</option>";
              }
            ?>
          </select>
          <div class="invalid-feedback">Select country.</div>
        </div>
        <div class="col mb-3">
          <label for="state" class="form-label fw-medium">State</label>
          <select class="form-control" id="state" name="state" required>
            <option value="">Select State</option>
          </select>
          <div class="invalid-feedback">Select state.</div>
        </div>
      </div>

      <div class="row">
        <div class="col mb-3">
          <label for="city" class="form-label fw-medium">City</label>
          <select class="form-control" id="city" name="city" required>
            <option value="">Select City</option>
          </select>
          <div class="invalid-feedback">Select city.</div>
        </div>
        <div class="col mb-3">
          <label for="pincode" class="form-label fw-medium">Pincode</label>
          <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required pattern="^\d{6}$" maxlength="6">
          <div class="invalid-feedback">Pincode must be 6 digits.</div>
        </div>
      </div>

      <!-- Image -->
      <div class="mb-3">
        <label for="profile_img" class="form-label fw-medium">Profile Image</label>
        <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*" required>
        <div class="invalid-feedback">Please upload a profile image.</div>
      </div>

      <button type="submit" class="btn btn-dark w-100" style="background-color:#333;border-radius:5px;transition:background 0.3s;"> Register </button>
    </form>
  </div>
</div>

<script>
(() => {
  'use strict';
  const form = document.getElementById('registerForm');
  const pwd = form.querySelector('#password');
  const cpwd = form.querySelector('#confirm_password');
  const cpfb = form.querySelector('#confirmPasswordFeedback');

  form.addEventListener('submit', e => {
    cpwd.setCustomValidity('');
    if (pwd.value !== cpwd.value) {
      cpwd.setCustomValidity('Passwords do not match.');
    }
    if (!form.checkValidity()) {
      e.preventDefault(); e.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  // AJAX for states
  document.getElementById('country').addEventListener('change', function(){
    let country_id = this.value;
    fetch("get_states.php?country_id="+country_id)
      .then(res => res.text())
      .then(data => {
        document.getElementById('state').innerHTML = data;
        document.getElementById('city').innerHTML = "<option value=''>Select City</option>";
      });
  });

  // AJAX for cities
  document.getElementById('state').addEventListener('change', function(){
    let state_id = this.value;
    fetch("get_cities.php?state_id="+state_id)
      .then(res => res.text())
      .then(data => {
        document.getElementById('city').innerHTML = data;
      });
  });

})();
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $country = $_POST['country'];
  $state = $_POST['state'];
  $city = $_POST['city'];
  $pincode = $_POST['pincode'];

  // Image handling
  $img = $_FILES['profile_img'];
  if ($img['error'] === 0) {
    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];
    if (in_array($ext, $allowed)) {
      $newName = uniqid('usr_') . '.' . $ext;
      if (!is_dir('profile_img')) {
        mkdir('profile_img', 0777, true);
      }
      move_uploaded_file($img['tmp_name'], "profile_img/" . $newName);
      $imgPath = "profile_img/" . $newName;
    } else {
      echo "<script>alert('Invalid image type.');</script>";
      exit;
    }
  } else {
    echo "<script>alert('Image upload error.');</script>";
    exit;
  }

  $qry = "INSERT INTO registration(name, phone_no, email, password, country, state, city, code, profile_img)
    VALUES('$name','$phone','$email','$password','$country','$state','$city','$pincode','$imgPath')";

  if (mysqli_query($con, $qry)) {
    $user_id = mysqli_insert_id($con);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $name;
    $_SESSION['user_img'] = $imgPath;
    echo "<script>alert('Welcome $name!'); location.href='user_profile.php?id=$user_id';</script>";
  } else {
    echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
  }
  mysqli_close($con);
}
include "footer.php";
?>
