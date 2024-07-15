<?php
include "../backend/db_connection.php";

$card_number = $_GET['card_number'];

// Prepare the SQL statement to check if the order exists
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM payments WHERE card_number = ?");
$stmt->bind_param("s", $card_number);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Check if the order exists
$orderExists = $row['count'] > 0;

$stmt->close();
$conn->close();

// Return the result as a JSON response
header('Content-Type: application/json');
echo json_encode($orderExists);
