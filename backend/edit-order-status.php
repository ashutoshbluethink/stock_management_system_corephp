<?php
include "db_connection.php";
$status_id  = $_POST['status_id'];
$status = $_POST['status'];


echo $sql = "UPDATE order_status SET status='$status' WHERE status_id =$status_id ";


if ($conn->query($sql) === TRUE) {
 
    echo '<script>alert("Update successful"); window.location.href = "../all-status.php";</script>';
    
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
