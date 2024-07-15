<?php
include "../backend/db_connection.php";
$orderIds = $_POST['orderIds'];
$orderStatus = $_POST['orderStatus'];
$selectedDate = $_POST['selectedDate']; 
$service_charge = $_POST['service_charge']; 
$vendor_id = $_POST['vendor_id']; 
$updated_at = date("Y-m-d H:i:s");
if (!empty($selectedDate)) {
    // Check the order status and update the corresponding date field
    if ($orderStatus == 1) {
        $dateField = 'created_at';
    } else {
        $dateField = 'updated_at';
    }

    $sql = "UPDATE orders SET order_status = '$orderStatus', service_charge = '$service_charge', $dateField = '$selectedDate', vendor_id = '$vendor_id' WHERE orderId IN (" . implode(',', $orderIds) . ")";
} else {
    $sql = "UPDATE orders SET order_status = '$orderStatus', service_charge = '$service_charge', vendor_id = '$vendor_id', updated_at = '$updated_at' WHERE orderId IN (" . implode(',', $orderIds) . ")";
}
if ($conn->query($sql) === TRUE) {
   
    echo "success";
} else {
    // Return an error response to the AJAX request
    echo "Error updating order status: " . $conn->error;
}
?>
