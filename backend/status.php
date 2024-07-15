<?php
    include "db_connection.php";

    // this is code for enable and disable the status 
        $account_id_list = $_GET['account_id'];
        $account_id_grid = $_GET['account_id_grid'];
        $card_id_grid = $_GET['card_id_grid'];
        $card_id_list = $_GET['card_id_list'];
      

        if(isset($account_id_list)){
            $sql = "SELECT * FROM accounts WHERE account_id = $account_id_list";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['account_status']);
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE accounts SET account_status = '{$a}' WHERE account_id = {$account_id_list}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../accounts-list.php");
            } 
        }
        
        if(isset($account_id_grid)){
            $sql = "SELECT * FROM accounts WHERE account_id = $account_id_grid";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['account_status']);
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE accounts SET account_status = '{$a}' WHERE account_id = {$account_id_grid}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../all-accounts.php");
            } 
        }
        
        if(isset($card_id_grid)){
            $sql = "SELECT * FROM payments WHERE card_id = $card_id_grid";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['card_status']);
            echo "$status";
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE payments SET card_status = '{$a}' WHERE card_id = {$card_id_grid}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../all-card.php");
            } 
        }
        
        if(isset($card_id_list)){
            $sql = "SELECT * FROM payments WHERE card_id = $card_id_list";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['card_status']);
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE payments SET card_status = '{$a}' WHERE card_id = {$card_id_list}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../card-list.php");
            } 
        }
        
?>
        