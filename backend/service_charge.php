<?php
session_start();
include "db_connection.php";
if (isset($_POST["submit"])) {
    $successMessage = ""; 
    $errorMessage = "";   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
       
        $service_charge_name = $_POST["service_charge_name"];
        $service_charge_amount = $_POST["service_charge_amount"];
      
        
            
            $sql = "INSERT INTO service_charge (service_charge_name, service_charge_amount) VALUES ('$service_charge_name', $service_charge_amount)";
            
            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Service Charge Added successfully!";
                header("location: ../service_charge.php");
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
                $_SESSION['errorMessage'] = $errorMessage;
                header("location: ../service_charge.php");
            }
     
    }
}

else if((isset($_POST["update"])) ){
    
        $successMessage = "";
        $errorMessage = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $service_charge_id = $_POST["service_charge_id"];
            $service_charge_name = $_POST["service_charge_name"];
            $service_charge_amount = $_POST["service_charge_amount"];

         $sql = "UPDATE service_charge SET service_charge_name = '$service_charge_name', service_charge_amount = $service_charge_amount WHERE service_charge_id = $service_charge_id";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['successMessage'] = "Service Charge updated successfully!";
                header("location: ../service_charge.php"); 
                exit;
            } else {
                $errorMessage = "Error: " . $conn->error;
            }
               
            $_SESSION['errorMessage'] = $errorMessage;
            header("location: ../service_charge.php?service_charge_id=" . $service_charge_id); 
        }

    }



?>
