<?php
include "db_connection.php";
$account_id  = $_POST['account_id'];

$accountGroup = $_POST['account_group'];
$accountType = $_POST['account_type'];
$mobileNumber = $_POST['mobile_number'];
$email = $_POST['email'];
$accountHolderName = $_POST['account_holder_name'];
$accountLoginPassword = $_POST['account_login_password'];
$comment = $_POST['comment'];
$account_status = 1;

// Check if an image file was uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageName = $_FILES['image']['name'];
    $uploadDirectory = "../uploads/";

    $targetFilePath = $uploadDirectory . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
        $sql = "UPDATE `accounts`
                SET `account_id`='$account_id',
                    `account_group`='$accountGroup',
                    `account_type`='$accountType',
                    `mobile_number`='$mobileNumber',
                    `email`='$email',
                    `account_holder_name`='$accountHolderName',
                    `account_login_password`='$accountLoginPassword',
                    `comment`='$comment',
                    `account_status`='$account_status',
                    `image`='$imageName'
                WHERE `account_id`='$account_id'";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Update successful"); window.location.href = "../all-accounts.php";</script>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
} else {
    $sql = "UPDATE `accounts`
            SET `account_id`='$account_id',
                `account_group`='$accountGroup',
                `account_type`='$accountType',
                `mobile_number`='$mobileNumber',
                `email`='$email',
                `account_holder_name`='$accountHolderName',
                `account_login_password`='$accountLoginPassword',
                `comment`='$comment',
                `account_status`='$account_status'
            WHERE `account_id`='$account_id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Update successful"); window.location.href = "../all-accounts.php";</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
