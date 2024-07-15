<?php
session_start();
include "db_connection.php";
if (isset($_POST["submit"])) {
    $successMessage = ""; 
    $errorMessage = "";   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploadDirectory = "../assets/img/payment_mode/"; 
        $imageName = $_FILES["payment_mode_img"]["name"];
        $imagePath = $uploadDirectory . $imageName;
      
        if (move_uploaded_file($_FILES["payment_mode_img"]["tmp_name"], $imagePath)) {
            $storeName = $_POST["payment_mode_name"];
            $status = 1;
            
            $sql = "INSERT INTO payment_mode (payment_mode_name, payment_mode_img, payment_mode_status) VALUES ('$storeName', '$imageName', $status)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Payment Modeadded successfully!";
                header("location: ../payment_mode.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
                $_SESSION['errorMessage'] = $errorMessage;
                header("location: ../payment_mode.php");
            }
        } else {
            echo $errorMessage = "Error uploading the image.";
            $_SESSION['errorMessage'] = $errorMessage;
            header("location: ../payment_mode.php");
        }
    }
}
else if((isset($_POST["update"])) ){

    $successMessage = "";
    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $payment_mode_id = $_POST["payment_mode_id"];
        $storeName = $_POST["payment_mode_name"];
        $payment_mode_status = $_POST["payment_mode_status"];

        if ($_FILES["payment_mode_img"]["name"]) {
            $uploadDirectory = "../assets/img/payment_mode/";
            $imageName = $_FILES["payment_mode_img"]["name"];
            $imagePath = $uploadDirectory . $imageName;
            if (move_uploaded_file($_FILES["payment_mode_img"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE payment_mode SET payment_mode_name = '$storeName', payment_mode_img = '$imageName', payment_mode_status = '$payment_mode_status' WHERE payment_mode_id = $payment_mode_id";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['successMessage'] = "Payment Mode updated successfully!";
                    header("location: ../payment_mode.php"); 
                    exit;
                } else {
                    $errorMessage = "Error: " . $conn->error;
                }
            } else {
                $errorMessage = "Error uploading the image.";
            }
        } else {
            $sql = "UPDATE payment_mode SET payment_mode_name = '$storeName', payment_mode_status = '$payment_mode_status' WHERE payment_mode_id = $payment_mode_id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Payment Mode name updated successfully!";
                header("location: ../payment_mode.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }
        }

        $_SESSION['errorMessage'] = $errorMessage;
        header("location: ../payment_mode.php?payment_mode_id=" . $payment_mode_id); 
    }

}


?>
