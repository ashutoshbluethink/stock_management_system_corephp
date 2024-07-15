<?php
session_start();
include "db_connection.php";

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
    $successMessage = ""; 
    $errorMessage = "";   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploadDirectory = "../assets/img/brand_logo/"; 
        $imageName = $_FILES["brand_img"]["name"];
        $imagePath = $uploadDirectory . $imageName;
      
        if (move_uploaded_file($_FILES["brand_img"]["tmp_name"], $imagePath)) {
            $brandName = $_POST["brand_name"];
            $status = 1;
            
            $sql = "INSERT INTO product_brand_name (brand_name, brand_img, brand_status) VALUES ('$brandName', '$imageName', $status)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "brand added successfully!";
                header("location: ../brand_add.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
                $_SESSION['errorMessage'] = $errorMessage;
                header("location: ../brand_add.php");
            }
        } else {
            echo $errorMessage = "Error uploading the image.";
            $_SESSION['errorMessage'] = $errorMessage;
            header("location: ../brand_add.php");
        }
    }
}
else if((isset($_POST["update"])) ){

    $successMessage = "";
    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $brand_id = $_POST["brand_id"];
        $brandName = $_POST["brand_name"];
        $brand_status = $_POST["brand_status"];

        if ($_FILES["brand_img"]["name"]) {
            $uploadDirectory = "../assets/img/brand_logo/";
            $imageName = $_FILES["brand_img"]["name"];
            $imagePath = $uploadDirectory . $imageName;
            if (move_uploaded_file($_FILES["brand_img"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE product_brand_name SET brand_name = '$brandName', brand_img = '$imageName', brand_status = '$brand_status' WHERE brand_id = $brand_id";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['successMessage'] = "brand updated successfully!";
                    header("location: ../brand_add.php"); 
                    exit;
                } else {
                    $errorMessage = "Error: " . $conn->error;
                }
            } else {
                $errorMessage = "Error uploading the image.";
            }
        } else {
            $sql = "UPDATE product_brand_name SET brand_name = '$brandName', brand_status = '$brand_status' WHERE brand_id = $brand_id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "brand name updated successfully!";
                header("location: ../brand_add.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }
        }

        $_SESSION['errorMessage'] = $errorMessage;
        header("location: ../brand_edit.php?brand_id=" . $brand_id); 
    }

}


?>
