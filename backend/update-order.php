<?php
session_start();
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $order_status = $_POST['actionButton'];
    $order_create_comment = $_POST['order_create_comment'];

    $accountId = $_POST['account_id'];
    $orderNo = $_POST['order_no'];
    $accountGroup = $_POST['account_group'];

    $cardId = $_POST['card_id'];
    $order_price = $_POST['order_price'];

    $productId = $_POST['product_id'];
    $color = $_POST['color'];
    $variant = $_POST['variant'];

    // Use UPDATE statement for existing record
    $sqlOrder = "UPDATE orders SET 
        account_id = '$accountId',
        card_id = '$cardId',
        product_id = '$productId',
        order_no = '$orderNo',
        color = '$color',
        varient = '$variant',
        order_status = '$order_status',
        order_price = $order_price,
        order_create_comment = '$order_create_comment'
        WHERE orderId = $orderId";

    mysqli_query($conn, $sqlOrder);

    $_SESSION['ordersuccessMessage'] = "Order Updated successfully. $orderNo";
    header("location: ../all-order.php");
    exit;
}
?>
