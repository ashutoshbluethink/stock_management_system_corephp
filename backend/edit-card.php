<?php
session_start();
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_id = $_POST["card_id"];
    $card_type = $_POST["card_type"];
    $account_type = $_POST["account_type"];
    $card_provider_company = $_POST["card_provider_company"];
    $card_number = $_POST["card_number"];
    $card_holder_name = $_POST["card_holder_name"];
    $card_provider_bank = $_POST["card_provider_bank"];
    $expiration_date = $_POST["expiration_date"];
    $cvv = $_POST["cvv"];
    $billing_date = $_POST["billing_date"];
    $card_limit = $_POST["card_limit"];
    $comment = $_POST["comment"];
    $card_status = $_POST["card_status"];

    // Prepare and execute the SQL query to update card details
     $sql = "UPDATE payments SET 
            card_type = '$card_type',
            account_type = '$account_type',
            card_provider_company = '$card_provider_company',
            card_number = '$card_number',
            card_holder_name = '$card_holder_name',
            card_provider_bank = '$card_provider_bank',
            expiration_date = " . ($expiration_date === "" ? "NULL" : $expiration_date) . ",
            cvv = " . ($cvv === "" ? "NULL" : $cvv) . ",
            billing_date = " . ($billing_date === "" ? "NULL" : $billing_date) . ",
            card_limit = " . ($card_limit === "" ? "NULL" : $card_limit) . ",
            comment = '$comment',
            card_status = '$card_status'
            WHERE card_id = $card_id";

    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['successMessage'] = "Card updated successfully";
        header("Location: ../all-card.php"); // Redirect to the card listing page
        exit();
    } else {
        session_start();
        $_SESSION['errorMessage'] = "Error updating card: " . mysqli_error($conn);
        header("Location: ../edit-card.php?card_id=$card_id"); // Redirect back to the edit page with an error message
        exit();
    }
} else {
    session_start();
    $_SESSION['errorMessage'] = "Error updating card method not match";
    header("Location: ../edit-card.php?card_id=$card_id"); // Redirect back to the edit page with an error message
    exit();
}
