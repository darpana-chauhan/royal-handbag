<?php
include "connection.php";
$country_id = $_GET['country_id'];
$q = mysqli_query($con, "SELECT * FROM state WHERE country_id='$country_id' ORDER BY name");
echo "<option value=''>Select State</option>";
while($row = mysqli_fetch_assoc($q)){
  echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>
