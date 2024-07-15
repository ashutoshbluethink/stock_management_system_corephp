<?php
session_start();
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand_name'];
    $modelName = $_POST['model_name'];
    $price = $_POST['price'];
    $comment = $_POST['comment'];

    $image = $_FILES['product_image']['name'];
    $imageTmpName = $_FILES['product_image']['tmp_name'];
    $imageUploadPath = '../uploads/product/' . $image;
    if (!is_dir('../uploads/product/')) {
        mkdir('../uploads/product/', 0777, true);
    }
$productstatus=1;
    if (move_uploaded_file($imageTmpName, $imageUploadPath)) {
         $sql = "INSERT INTO products (brand, model_name ) VALUES ('$brand', '$modelName')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['successMessage'] = "Product added successfully!";
            header("Location: ../add-product.php");
        } else {
            $_SESSION['errorMessage'] = "Error: " . $conn->error;
            header("Location: ../add-product.php");
        }
    } else {
        $_SESSION['errorMessage'] = "Error moving uploaded file.";
        header("Location: ../add-product.php");
    }

    // Redirect to the appropriate page
    header("Location: ../add-product.php");
    exit;
}
?>
