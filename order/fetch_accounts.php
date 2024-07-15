<?php
include "../backend/db_connection.php";

$storeName = $_GET['store_name'];

$sqlAccount = "SELECT * FROM accounts WHERE account_status = 1 AND account_group = '$storeName'";
$result = mysqli_query($conn, $sqlAccount);

$accounts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $account = [
        'account_id' => $row['account_id'],
        'mobile_number' => $row['mobile_number'],
        'account_holder_name' => $row['account_holder_name']
    ];
    $accounts[] = $account;
}

header('Content-Type: application/json');
echo json_encode($accounts);
?>
