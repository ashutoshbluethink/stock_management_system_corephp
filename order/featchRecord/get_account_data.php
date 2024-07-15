<?php
include "../../backend/db_connection.php";

if (isset($_GET['account_id'])) {
    $accountID = $_GET['account_id'];

    $sql = "SELECT * FROM accounts WHERE account_id = '$accountID'";
    
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
    // Handle the case when account_id parameter is not set
    echo "account ID not provided.";
}

?>
