<?php

session_start();
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["submit"])) {
     
        // Code for adding a new vendor
        $uploadDirectory = "../assets/img/vendor/";
        $imageName = $_FILES["vendor_image"]["name"];
        $imagePath = $uploadDirectory . $imageName;
        // echo"ss";
        // die;
        if (move_uploaded_file($_FILES["vendor_image"]["tmp_name"], $imagePath)) {
            $vendorName = $_POST["vendor_name"];

            $sql = "INSERT INTO vendor (vendor_name, vendor_image) VALUES ('$vendorName', '$imageName')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Vendor added successfully!";
            } else {
                $_SESSION['errorMessage'] = "Error: " . $conn->error;
            }
        } else {
            $_SESSION['errorMessage'] = "Error uploading the image.";
        }
    } elseif (isset($_POST["update"])) {
        // Code for updating an existing vendor
        $vendorId = $_POST["vendor_id"];
        $vendorName = $_POST["vendor_name"];
        $vendorStatus = $_POST["vendor_status"];

        if ($_FILES["vendor_image"]["name"]) {
            $uploadDirectory = "../assets/img/vendor/";
            $imageName = $_FILES["vendor_image"]["name"];
            $imagePath = $uploadDirectory . $imageName;

            if (move_uploaded_file($_FILES["vendor_image"]["tmp_name"], $imagePath)) {
                $sql = "UPDATE vendor SET vendor_name = '$vendorName', vendor_image = '$imageName', vendor_status = '$vendorStatus' WHERE vendor_id = $vendorId";
            } else {
                $_SESSION['errorMessage'] = "Error uploading the image.";
            }
        } else {
            $sql = "UPDATE vendor SET vendor_name = '$vendorName', vendor_status = '$vendorStatus' WHERE vendor_id = $vendorId";
        }

        if ($conn->query($sql) === TRUE) {
            $_SESSION['successMessage'] = "Vendor updated successfully!";
        } else {
            $_SESSION['errorMessage'] = "Error: " . $conn->error;
        }
    }
    header("location: ../vendor_add.php");
}
?>
