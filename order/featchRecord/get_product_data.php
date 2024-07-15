<?php
include "../../backend/db_connection.php";

if (isset($_GET['product_id'])) {
    $productID = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE product_id = '$productID'";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        
        // Return the data as JSON response
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // Handle the case when the query fails
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle the case when product_id parameter is not set
    echo "products ID not provided.";
}

?>
