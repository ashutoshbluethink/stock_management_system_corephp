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
        $uploadDirectory = "../assets/img/store_logo/"; 
        $imageName = $_FILES["store_image"]["name"];
        $imagePath = $uploadDirectory . $imageName;
      
        if (move_uploaded_file($_FILES["store_image"]["tmp_name"], $imagePath)) {
            $storeName = $_POST["store_name"];
            $status = 1;
            
            $sql = "INSERT INTO store (store_name, store_img, store_status) VALUES ('$storeName', '$imageName', $status)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Store added successfully!";
                header("location: ../store_add.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
                $_SESSION['errorMessage'] = $errorMessage;
                header("location: ../store_add.php");
            }
        } else {
            echo $errorMessage = "Error uploading the image.";
            $_SESSION['errorMessage'] = $errorMessage;
            header("location: ../store_add.php");
        }
    }
}
else if((isset($_POST["update"])) ){

    $successMessage = "";
    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $store_id = $_POST["store_id"];
        $storeName = $_POST["store_name"];
        $store_status = $_POST["store_status"];

        if ($_FILES["store_image"]["name"]) {
            $uploadDirectory = "../assets/img/store_logo/";
            $imageName = $_FILES["store_image"]["name"];
            $imagePath = $uploadDirectory . $imageName;
            if (move_uploaded_file($_FILES["store_image"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE store SET store_name = '$storeName', store_img = '$imageName', store_status = '$store_status' WHERE store_id = $store_id";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['successMessage'] = "Store updated successfully!";
                    header("location: ../store_add.php"); 
                    exit;
                } else {
                    $errorMessage = "Error: " . $conn->error;
                }
            } else {
                $errorMessage = "Error uploading the image.";
            }
        } else {
            $sql = "UPDATE store SET store_name = '$storeName', store_status = '$store_status' WHERE store_id = $store_id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Store name updated successfully!";
                header("location: ../store_add.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }
        }

        $_SESSION['errorMessage'] = $errorMessage;
        header("location: ../store_edit.php?store_id=" . $store_id); 
    }

}


?>
