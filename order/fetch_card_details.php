<?php

// include "../backend/db_connection.php";

// $paymentMode = $_POST['payment_mode'];

// // Prepare the SQL query to fetch card details based on the payment mode
// $sql = "SELECT * FROM payments WHERE card_status = 1 AND card_type = '$paymentMode'";
// $result = mysqli_query($conn, $sql);


include "../backend/db_connection.php";

$paymentMode = $_POST['payment_mode'];
$cardProviderBank = $_POST['choosing_card_provider_bank'];

// Prepare the SQL query to fetch card details based on the payment mode and card provider bank
$sql = "SELECT * FROM payments WHERE card_status = 1 AND card_type = '$paymentMode' AND card_provider_bank = '$cardProviderBank'";
$result = mysqli_query($conn, $sql);


// Create an empty array to store the card details
$cardDetails = array();

// Fetch the card details from the result set
while ($row = mysqli_fetch_assoc($result)) {
    $cardDetails[] = array(
        'card_id' => $row['card_id'],
        'card_number' => $row['card_number'],
        'card_holder_name' => $row['card_holder_name']
    );
}

// Encode the card details as JSON and echo the response
echo json_encode($cardDetails);
