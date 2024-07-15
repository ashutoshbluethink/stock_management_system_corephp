<?php


// Include the database connection file
include "db_connection.php";

// Get form values
$cardType = mysqli_real_escape_string($conn, $_POST['card_type']);
$account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
$card_provider_company = mysqli_real_escape_string($conn, $_POST['card_provider_company']);

$cardNumber = mysqli_real_escape_string($conn, $_POST['card_number']);
$cardNumber = str_replace('-', '', $cardNumber);


$cardHolderName = mysqli_real_escape_string($conn, $_POST['card_holder_name']);
$cardProviderBank = mysqli_real_escape_string($conn, $_POST['card_provider_bank']);
$expirationDate = mysqli_real_escape_string($conn, $_POST['expiration_date']);

$cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
$comment = mysqli_real_escape_string($conn, $_POST['comment']);
$card_limit = mysqli_real_escape_string($conn, $_POST['card_limit']);
$billingDate = mysqli_real_escape_string($conn, $_POST['billing_date']);


// Retrieve image data
$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];
$imageSize = $_FILES['image']['size'];

// Validate and process the uploaded image
if ($imageName) {
    // Specify the upload directory
    $uploadDirectory = "../uploads/card/";
    $imageDestination = $uploadDirectory . $imageName;
    move_uploaded_file($imageTmpName, $imageDestination);
} else {
    $imageName = "user.jpg";
}

// Set card limit and billing date to null if card type is "Debit"
if ($cardType === "Debit") {
    $card_limit = 0;
    $billingDate = 0;
}

if ($card_limit === "") {
    $card_limit = 0;
}

if ($billingDate === "") {
    $billingDate = 0;
}


if($cvv === ""){
    $cvv=000;
}
$card_status = 1;
// Prepare the SQL query with placeholders
$sql = "INSERT INTO payments (card_type, account_type, card_provider_company, card_number, card_holder_name, card_provider_bank, expiration_date,        cvv, image, card_limit, comment, billing_date, card_status) 
        VALUES ('$cardType', '$account_type', '$card_provider_company', '$cardNumber', '$cardHolderName', '$cardProviderBank', '$expirationDate', '$cvv', '$imageName', '$card_limit', '$comment', '$billingDate', '$card_status')";

// Execute the SQL statement
if (mysqli_query($conn, $sql)) {
    ?>
    <script>
        alert('Card Save Successfully');
        window.location.href = "../add-card.php";
    </script>
    <?php
} else {
    echo 'Error: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
