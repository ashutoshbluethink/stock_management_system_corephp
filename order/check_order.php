<?php
include "../backend/db_connection.php";

$orderNo = $_GET['order_no'];

// Prepare the SQL statement to check if the order exists
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM orders WHERE order_no = ?");
$stmt->bind_param("s", $orderNo);
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
