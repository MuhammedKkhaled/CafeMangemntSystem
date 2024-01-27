<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once("../../functions/dd.php");
    require_once("../../DB/db_config.php");

    date_default_timezone_set("Africa/Cairo");
    // Escape user inputs for security
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password =  hash("md5", $_POST['password']);
    $is_admin =  $_POST['is_admin'];
    $created_at = date('Y-m-d h:i:s');

    // Attempt insert query execution
    $insertQuery = "INSERT INTO users (username, email, password, is_admin, created_at) VALUES ('$userName', '$email', '$password', '$is_admin', '$created_at')";

    if (mysqli_query($conn, $insertQuery)) {

        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    } else {
        $_SESSION['message_error'] = "يوجد خطا الان في البيانات برجاء الرجوع مرة اخري ";
        $referrerPage = $_SERVER['HTTP_REFERER'];
        header("Location: $referrerPage");
        exit();
    }


    // Close connection
    mysqli_close($conn);
} else {
    header("Location: ../index.php");
    exit();
}
