<?php
include "db_connection.php";
$accountGroup = $_POST['account_group'];
$accountType = $_POST['account_type'];
$mobileNumber = $_POST['mobile_number'];
$email = $_POST['email'];
$accountHolderName = $_POST['account_holder_name'];
$accountLoginPassword = $_POST['account_login_password'];
$comment = $_POST['comment'];
$account_status = 1;

    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];

    if ($imageName) {
        $uploadDirectory = "../uploads/";
        $imageDestination = $uploadDirectory . $imageName;
        move_uploaded_file($imageTmpName, $imageDestination);
    } else {
        $imageName = "user.jpg";
    }

$sql = "INSERT INTO accounts (account_group, account_type, mobile_number, email, account_holder_name, account_login_password, image, comment, account_status)
        VALUES ('$accountGroup', '$accountType', '$mobileNumber', '$email', '$accountHolderName', '$accountLoginPassword', '$imageName', '$comment', '$account_status')";

// Execute the SQL statement
if (mysqli_query($conn, $sql)) {
    ?>
    <script>
        alert('Data Save Successfully');
        window.location.href = "../add-accounts.php";
    </script>
    <?php
} else {
    echo 'Error: ' . mysqli_error($conn);
}


// Close the database connection
mysqli_close($conn);
?>
