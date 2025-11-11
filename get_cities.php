<?php
include "connection.php";
$state_id = $_GET['state_id'];
$q = mysqli_query($con, "SELECT * FROM city WHERE state_id='$state_id' ORDER BY name");
echo "<option value=''>Select City</option>";
while($row = mysqli_fetch_assoc($q)){
  echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>
