<?php
include 'connection.php';

$q = isset($_GET['q']) ? mysqli_real_escape_string($con, $_GET['q']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - Royal</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Search Results for: <span style="color:red;"><?= htmlspecialchars($q) ?></span></h3>
    <div class="row mt-3">
        <?php
        if (!empty($q)) {
            $sql = "SELECT p.id, p.name, c.name AS category_name
                    FROM products p
                    JOIN categories c ON p.category_id = c.id
                    WHERE p.name LIKE '%$q%' 
                       OR c.name LIKE '%$q%'";
            $query = mysqli_query($con, $sql) or die(mysqli_error($con));

            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="col-md-12 mb-2">
                        <a href="product.php?q=<?= urlencode($row['name']) ?>" 
                           class="d-block p-2 border rounded text-dark text-decoration-none">
                            <?= htmlspecialchars($row['name']) ?>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
        } else {
            echo "<p>Please enter a search term.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
