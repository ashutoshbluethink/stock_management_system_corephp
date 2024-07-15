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
        $uploadDirectory = "../assets/img/bank_logo/"; 
        $imageName = $_FILES["bank_image"]["name"];
        $imagePath = $uploadDirectory . $imageName;
      
        if (move_uploaded_file($_FILES["bank_image"]["tmp_name"], $imagePath)) {
            $bankName = $_POST["bank_name"];
            $status = 1;
            
            $sql = "INSERT INTO bank_name (bank_name, bank_img, bank_status) VALUES ('$bankName', '$imageName', $status)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "bank added successfully!";
                header("location: ../bank_add.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
                $_SESSION['errorMessage'] = $errorMessage;
                header("location: ../bank_add.php");
            }
        } else {
            echo $errorMessage = "Error uploading the image.";
            $_SESSION['errorMessage'] = $errorMessage;
            header("location: ../bank_add.php");
        }
    }
}

else if((isset($_POST["update"])) ){

    $successMessage = "";
    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bank_id = $_POST["bank_id"];
        $bankName = $_POST["bank_name"];
        $bank_status = $_POST["bank_status"];

        if ($_FILES["bank_image"]["name"]) {
            $uploadDirectory = "../assets/img/bank_logo/";
            $imageName = $_FILES["bank_image"]["name"];
            $imagePath = $uploadDirectory . $imageName;
            if (move_uploaded_file($_FILES["bank_image"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE bank_name SET bank_name = '$bankName', bank_img = '$imageName', bank_status = '$bank_status' WHERE bank_id = $bank_id";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['successMessage'] = "bank updated successfully!";
                    header("location: ../bank_add.php?bank_id=" . $bank_id); 
                    exit;
                } else {
                    $errorMessage = "Error: " . $conn->error;
                }
            } else {
                $errorMessage = "Error uploading the image.";
            }
        } else {
            $sql = "UPDATE bank_name SET bank_name = '$bankName', bank_status = '$bank_status' WHERE bank_id = $bank_id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "bank name updated successfully!";
                header("location: ../bank_add.php?bank_id=" . $bank_id); 
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }
        }

        $_SESSION['errorMessage'] = $errorMessage;
        header("location: ../bank_add.php?bank_id=" . $bank_id); 
    }

}



?>


