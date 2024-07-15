<?php
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $brand_id = $_POST["brand_name"];
    $model_name = $_POST["model_name"];
    $price = $_POST["price"];
    $comment = $_POST["comment"];

    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/product/"; 
        $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
        
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
         
            $product_image = $_FILES["product_image"]["name"];
            $sql = "UPDATE products SET brand = '$brand_id', model_name = '$model_name', price = '$price', product_image = '$product_image', comment = '$comment' WHERE product_id = $product_id";
        }
    } else {
        $sql = "UPDATE products SET brand = '$brand_id', model_name = '$model_name', price = '$price', comment = '$comment' WHERE product_id = $product_id";
    }

    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['successMessage'] = "Product updated successfully";
        header("Location: ../all-product.php"); 
        exit();
    } else {
        session_start();
        $_SESSION['errorMessage'] = "Error updating product: " . mysqli_error($conn);
        header("Location: ../product_edit.php?product_id_list=$product_id"); 
        exit();
    }
} else {
    session_start();
    $_SESSION['errorMessage'] = "Error updating product method not match: " . mysqli_error($conn);
    header("Location: ../product_edit.php?product_id_list=$product_id"); 
    exit();
}
?>
