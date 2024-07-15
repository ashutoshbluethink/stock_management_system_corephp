<?php
session_start();
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand_name'];
    $modelName = $_POST['model_name'];
    $productstatus = 1;
    // Insert product details into the products table
    $sql_insert_product = "INSERT INTO products (brand, model_name, productstatus) VALUES ('$brand', '$modelName', $productstatus)";
    if ($conn->query($sql_insert_product) === FALSE) {
        $_SESSION['errorMessage'] = "Error: " . $conn->error;
        header("Location: ../add-product.php");
        exit;
    }

    // Get the product ID of the inserted product
    $productId = $conn->insert_id;

    // Create products_configurable_varients table if not exists
    $sql_create_variants_table = "CREATE TABLE IF NOT EXISTS products_configurable_varients (
        variant_id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT,
        price DECIMAL(10,2),
        variant VARCHAR(255),
        color VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql_create_variants_table) === FALSE) {
        $_SESSION['errorMessage'] = "Error creating variants table: " . $conn->error;
        header("Location: ../add-product.php");
        exit;
    }

    // Insert variant details into the products_configurable_varients table in a loop
    for ($i = 0; $i < count($_POST['price']); $i++) {
        $price = $_POST['price'][$i];
        $variant = $_POST['variant'][$i];
        $color = $_POST['color'][$i];

        // Insert variant details into the products_configurable_varients table
        $sql_insert_variant = "INSERT INTO products_configurable_varients (product_id, price, variant, color) 
                                VALUES ('$productId', '$price', '$variant', '$color')";
        if ($conn->query($sql_insert_variant) === FALSE) {
            $_SESSION['errorMessage'] = "Error inserting variant: " . $conn->error;
            header("Location: ../add-product.php");
            exit;
        }
    }

    // Create products_configurable_color table if not exists
    $sql_create_color_table = "CREATE TABLE IF NOT EXISTS products_configurable_color (
        color_id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT,
        color_name VARCHAR(50),
        product_image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql_create_color_table) === FALSE) {
        $_SESSION['errorMessage'] = "Error creating color table: " . $conn->error;
        header("Location: ../add-product.php");
        exit;
    }

    // Insert color details into the products_configurable_color table in a loop
    for ($i = 0; $i < count($_POST['color']); $i++) {
        $color = $_POST['color'][$i];
        $image = $_FILES['product_image']['name'][$i];
        $imageTmpName = $_FILES['product_image']['tmp_name'][$i];
        $imageUploadPath = '../uploads/product/images/' . $image;

        // Move uploaded image to the designated folder
        if (move_uploaded_file($imageTmpName, $imageUploadPath)) {
            // Insert color details into the products_configurable_color table
            $sql_insert_color = "INSERT INTO products_configurable_color (product_id, color_name, product_image) 
                                VALUES ('$productId', '$color', '$image')";
            if ($conn->query($sql_insert_color) === FALSE) {
                $_SESSION['errorMessage'] = "Error inserting color: " . $conn->error;
                header("Location: ../add-product.php");
                exit;
            }
        } else {
            $_SESSION['errorMessage'] = "Error moving uploaded file.";
            header("Location: ../add-product.php");
            exit;
        }
    }

    $_SESSION['successMessage'] = "Product and variants added successfully!";
    header("Location: ../add-product.php");
    exit;
}
?>
