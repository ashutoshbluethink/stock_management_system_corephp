<?php
$host='localhost';
$user='root';
$pwd='admin@123';
// $database='stock_live_29112023';
$database='stock';

$conn=mysqli_connect("$host","$user","$pwd","$database") or die("error to connect");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>