<?php
    include "db_connection.php";

    // this is code for enable and disable the status 
        $product_id_list = $_GET['product_id_list'];
        $product_id_grid = $_GET['product_id_grid'];      

        if(isset($product_id_list)){
            $sql = "SELECT * FROM products WHERE product_id = $product_id_list";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['productstatus']);
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE products SET productstatus = '{$a}' WHERE product_id = {$product_id_list}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../all-product.php");
            } 
        }
        
        if(isset($product_id_grid)){
            $sql = "SELECT * FROM products WHERE product_id = $product_id_grid";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);
            $status = intval($data['productstatus']);
            $a = ($status == 1) ? 0 : 1;
            
            $sql = "UPDATE products SET productstatus = '{$a}' WHERE product_id = {$product_id_grid}";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
            
            if ($result == true) {
            header("location: ../all-product.php");
            } 
        }
       
        
?>
        