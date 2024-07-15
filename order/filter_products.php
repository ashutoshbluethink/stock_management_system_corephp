<?php
include "../backend/db_connection.php";

$selectedBrand = $_GET['brand'];
$escapedBrand = mysqli_real_escape_string($conn, $selectedBrand);

// Build the SQL query
// $sql = "SELECT * FROM products WHERE productstatus = 1 AND brand = '$escapedBrand'";

$sql = "SELECT p.*, b.* 
        FROM products AS p
        LEFT JOIN product_brand_name AS b ON p.brand = b.brand_id
        WHERE p.productstatus = 1 AND p.brand = '$selectedBrand'";

$result = mysqli_query($conn, $sql);

$filteredProducts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $filteredProducts[] = $row;
}

header('Content-Type: application/json');

echo json_encode($filteredProducts);

mysqli_close($conn);
?>
