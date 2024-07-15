<?php
include "../../backend/db_connection.php";

if (isset($_GET['card_id'])) {
    $cardID = $_GET['card_id'];

    $sql = "SELECT p.*, b.bank_name
    FROM payments p
    LEFT JOIN bank_name b ON p.card_provider_bank = b.bank_id
    WHERE p.card_id = '$cardID'
    ";
    
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
    // Handle the case when card_id parameter is not set
    echo "account ID not provided.";
}

?>
