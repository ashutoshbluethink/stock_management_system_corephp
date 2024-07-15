<?php
session_start();
include "db_connection.php";

ini_set('display_errors', 1); 
error_reporting(E_ALL);

if (isset($_POST["submit"])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
        $uploadDirectory = "../assets/img/store_logo/";
        $imageName = $_FILES["order_status_img"]["name"];
         $imagePath = $uploadDirectory . $imageName;
      
        $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
      
        if (!in_array($imageFileType, $allowedExtensions)) {
            $_SESSION['errorMessage'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF images are allowed.";
            header("location: ../add-order-status.php");
            exit;
        }
        
        if (move_uploaded_file($_FILES["order_status_img"]["tmp_name"], $imagePath)) {
            $storeName = $_POST["order_status_label"];
            $status = 1;
         
            $sql = "INSERT INTO order_status (order_status_label, order_status_img, order_status) VALUES ('$storeName', '$imageName', $status)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Order Status added successfully!";
                header("location: ../add-order-status.php");
                exit;
            } else {
                error_log("Error: " . $conn->error);
                $_SESSION['errorMessage'] = "An error occurred while adding the Order Status .";
                header("location: ../add-order-status.php");
            }
        } else {
            $_SESSION['errorMessage'] = "Error uploading the logo.";
            header("location: ../add-order-status.php");
        }
    }
} else if (isset($_POST["update"])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $status_id = $_POST["status_id"];
        $storeName = $_POST["order_status_label"];
        $order_status = $_POST["order_status"];

        if ($_FILES["order_status_img"]["name"]) {
            $uploadDirectory = "../assets/img/store_logo/";
             $imageName = $_FILES["order_status_img"]["name"];
              $imagePath = $uploadDirectory . $imageName;
           
            // Check if the uploaded file is an image
             $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");
            
            if (!in_array($imageFileType, $allowedExtensions)) {
                $_SESSION['errorMessage'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF images are allowed.";
                header("location: ../add-order-status.php?status_id=" . $status_id);
                exit;
            }
       
            if (move_uploaded_file($_FILES["order_status_img"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE order_status SET order_status_label = '$storeName', order_status_img = '$imageName', order_status = '$order_status' WHERE status_id = $status_id";
            } else {
                $_SESSION['errorMessage'] = "Error uploading the image.";
                header("location: ../add-order-status.php?status_id=" . $status_id);
                exit;
            }
        } else {
            $sql = "UPDATE order_status SET order_status_label = '$storeName', order_status = '$order_status' WHERE status_id = $status_id";
        }

        if ($conn->query($sql) === TRUE) {
            $_SESSION['successMessage'] = "Store updated successfully!";
            header("location: ../add-order-status.php");
            exit;
        } else {
            error_log("Error: " . $conn->error);
            $_SESSION['errorMessage'] = "An error occurred while updating the store.";
            header("location: ../add-order-status.php?status_id=" . $status_id);
        }
    }
}
?>
