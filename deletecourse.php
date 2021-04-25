<?php
require_once "databaseconnection.php";
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$course_id=$_SESSION["course_id"];
$user_id = $_SESSION["user_id"];

$sql = "delete from course where course_id='$course_id' and user_id = '$user_id'";

if($conn->query($sql)===TRUE){

    header("location: welcome.php");
}

$conn->close();
?>