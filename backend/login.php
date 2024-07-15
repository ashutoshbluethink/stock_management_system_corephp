<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    include "db_connection.php";
    $user = authenticateUser($username, $password);
    if ($user) {
      
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_login_at'] = $user['last_login_at'];

        header('Location: ../dashboard.php');
        exit();
    } else {
    
        $error = 'Invalid username or password';
        $_SESSION['errorMessage'] = $error;
        header('Location: ../index.php');
    }
}

function authenticateUser($username, $password) {
    global $conn;
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
 
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userIp = $_SERVER['REMOTE_ADDR'];
        $query = "UPDATE users SET last_login_ip = '$userIp', last_login_at = NOW(), updated_at = NOW() WHERE id = " . $user['id'];
        $conn->query($query);
        return $user;
    } else {

        return false;
    }
}

?>
