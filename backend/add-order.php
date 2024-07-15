<?php
    session_start();
    include "db_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve values from the Accounts Detail section
    $accountId = $_POST['account_id'];
    $orderNo = $_POST['order_no'];
    $accountGroup = $_POST['account_group'];

    // Retrieve values from the Payment Detail section
    $cardId = $_POST['card_id'];
    $order_price = $_POST['order_price'];

    // Retrieve values from the Product Details section
    $productId = $_POST['product_id'];
    $color = $_POST['color'];
    $variant = $_POST['variant'];

    
    $expectedDeliveryDate = $_POST['expected_delivery_date'];
    // $currentDate = date('Y-m-d H:i:s');
    // $defaultExpectedDeliveryDate = date('Y-m-d', strtotime($currentDate . ' + 3 days'));
    // $finalExpectedDeliveryDate = !empty($expectedDeliveryDate) ? $expectedDeliveryDate : $defaultExpectedDeliveryDate;


    $orderComment = $_POST['order_create_comment'];
    // $defaultOrderComment = "Default Comment";
    // $finalOrderComment = !empty($orderComment) ? $orderComment : $defaultOrderComment;


    // ===========================================
    $service_charge = 00 ;
    $queryservice_charge = "SELECT * FROM service_charge";

    $resultsservice_charge = mysqli_query($conn, $queryservice_charge);										
    while ($result = mysqli_fetch_assoc($resultsservice_charge)) {

    $service_charge = $result['service_charge_amount']; 
    }

// ===========================================
    // Save data in the accounts table if the account ID is empty
    if ($accountId=="other") {
        $brandName = $_POST['account_group'];
        $accountType = "custom";
        $mobileNumber = $_POST['mobile_number'];
        $email = $_POST['email'];
        $accountHolderName = $_POST['account_holder_name'];
        $accountComment = $_POST['accountcomment'];
        if($accountComment == ""){
            $accountComment = "NA" ;
        }
        $account_status = 1;

        $sqlAccounts = "INSERT INTO accounts (account_group, account_type, mobile_number, email, account_holder_name, comment, account_status) 
                        VALUES ('$accountGroup', '$accountType', '$mobileNumber', '$email', '$accountHolderName', '$accountComment', $account_status)";
        mysqli_query($conn, $sqlAccounts);
        // Get the inserted card ID
        $accountIdInserted = mysqli_insert_id($conn);
    } else {
        $accountIdInserted = $accountId;
    }

    // Save data in the payment table if the card ID is empty
    if ($cardId=="other") {
        $paymentMode = $_POST['payment_mode'];
        $payment_type = "custom";
        $cardNumber = $_POST['card_number']; 
        $cardHolderName = $_POST['card_holder_name'];
        $cardProviderBank = $_POST['card_provider_bank'];
        $paymentComment = $_POST['paymentcomment'];
        if($paymentComment == ""){
            $paymentComment = "NA" ;
        }
        $card_status = 1;
        $sqlPayment = "INSERT INTO payments (card_type, account_type, card_number, card_holder_name, card_provider_bank, comment, card_status) 
                    VALUES ('$paymentMode', '$payment_type', '$cardNumber', '$cardHolderName', '$cardProviderBank', '$paymentComment', '$card_status')";
        mysqli_query($conn, $sqlPayment);
        // Get the inserted card ID
        $cardIdInserted = mysqli_insert_id($conn);
    } else {
        $cardIdInserted = $cardId;
    }

    // Save data in the products table if the product ID is empty
    if ($productId=="other") {
    $productBrandName = $_POST['product_brand_name'];
    $modelName = $_POST['model_name'];
    $price = $_POST['price'];
    $productComment = $_POST['productcomment'];
    if($productComment == ""){
        $productComment = "NA" ;
    }
    $productstatus = 1;
    $image="product.jpg";
    $sqlProducts = "INSERT INTO products (brand, model_name, price, comment, productstatus, product_image) 
                    VALUES ('$productBrandName', '$modelName', '$price', '$productComment', $productstatus, $image)";
    mysqli_query($conn, $sqlProducts);
    
    // Get the inserted product ID
        $productIdInserted = mysqli_insert_id($conn);
    } else {
        $productIdInserted = $productId;
    }

    // Save data in the order table
    if($order_price == ""){
        $order_price = $_POST['price'] ;
    }
    $order_location = $_POST['order_location'] ;

    $order_status = 1 ;
    $sqlOrder = "INSERT INTO orders (account_id, card_id, product_id, order_no, color, varient, order_status, order_price, order_location, service_charge, order_create_comment, expected_delivery_date) 
             VALUES ('$accountIdInserted', '$cardIdInserted', '$productIdInserted', '$orderNo', '$color', '$variant', '$order_status', $order_price, '$order_location', $service_charge, '$orderComment', '$expectedDeliveryDate')";

            mysqli_query($conn, $sqlOrder);
            $last_Order_id = mysqli_insert_id($conn);
            $_SESSION['ordersuccessMessage'] = "New Order Created successfully. $orderNo";
            header("location: ../add-order.php");
            exit;

}
    ?>
 
