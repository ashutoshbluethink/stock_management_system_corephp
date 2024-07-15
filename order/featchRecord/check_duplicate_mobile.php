<?php
include "../../backend/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mobileNumber = $_POST["mobile_number"];
    $storeID = $_POST["store_id"];

    $sql = "SELECT COUNT(*) as count FROM accounts WHERE mobile_number = '$mobileNumber' AND account_group = '$storeID'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row["count"] > 0) {
            echo "duplicate";
        } else {
            echo "not_duplicate";
        }
    } else {
        echo "error";
    }
}
?>
