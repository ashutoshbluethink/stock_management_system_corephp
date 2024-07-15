<?php
include "../../backend/db_connection.php";

if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Prepare and execute SQL query to fetch colors for the selected product
    $sql = "SELECT color_id, color_name, product_image FROM products_configurable_color WHERE product_id = '$productId'";
    $result = $conn->query($sql);

    // Check if any colors are fetched
    if ($result->num_rows > 0) {
        $colors = array();
        while ($row = $result->fetch_assoc()) {
            $colors[] = $row;
        }
        // Return JSON response with fetched colors
        echo json_encode(array('colors' => $colors));
    } else {
        // Return JSON response indicating no colors found
        echo json_encode(array('error' => 'No colors found for the selected product'));
    }
} else {
    // Return JSON response indicating product_id is missing or empty
    echo json_encode(array('error' => 'Product ID is missing or empty'));
}
?>
